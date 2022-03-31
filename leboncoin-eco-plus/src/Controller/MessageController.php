<?php

namespace App\Controller;

use App\DTO\MessageDto;
use App\Entity\Message;
use App\Entity\Product;
use App\Entity\User;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use DateTime;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController {
    #[Route('/message/list', name: 'message_list')]
    public function list(MessageRepository $messageRepository): Response {

        $user = $this->getUser(); /** @var User $user */
        $messages = $messageRepository->getConversations($user->getId());

        $conversations = [];

        foreach($messages as $message) {
            $productId = $message->getProduct()->getId();
            if (!isset($conversations[$productId]))
                $conversations[$productId] = ['product' => $message->getProduct(), 'messages' => []];
            $conversations[$productId]['messages'][] = $message;
        }

        return $this->render('message/list.html.twig', [
            'conversations' => $conversations
        ]);
    }

    #[Route('/message/detail/{id}', name: 'message_detail')]
    public function detail(Product $product, MessageRepository $messageRepository): Response {
        $user = $this->getUser(); /** @var User $user */
        $productId = $product->getId();
        $senderId = $user->getId();
        $receiverId = $product->getUser()->getId();
        $messages = $messageRepository->getConversation($productId, $senderId, $receiverId);

        return $this->render('message/detail.html.twig', [
            'messages' => $messages,
            'sender' => $user,
            'product' => $product
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/message/new/{id}', name: 'message_new')]
    public function new(Request $request, Product $product, MessageRepository $messageRepository): Response {
        $sender = $this->getUser(); /** @var User $sender */
        if ($sender == null) return $this->redirectToRoute('account_login');

        $messageDto = new MessageDto();
        $form = $this->createForm(MessageType::class, $messageDto, ['validation_groups' => ['Default', 'add']]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = new Message();
            $messageDto->setEntityFromDto($message);
            $message->setDate(new DateTime());
            $message->setSender($sender);
            $message->setReceiver($product->getUser());
            $message->setProduct($product);
            $messageRepository->add($message);
            return $this->redirectToRoute('message_detail', [ 'id' => $product->getId() ]);
        }

        return $this->render('message/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
