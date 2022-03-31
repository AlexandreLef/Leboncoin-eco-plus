<?php

namespace App\Controller;

use App\DTO\MessageDto;
use App\Entity\Message;
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
    public function list(): Response {return $this->render('message/list.html.twig', ['controller_name' => 'MessageController',]);}

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/message/new/{id}', name: 'message_new')]
    public function newMessage(Request $request, User $receiver, MessageRepository $messageRepository): Response {
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
            $message->setReceiver($receiver);
            $messageRepository->add($message);
            return $this->redirectToRoute('message_list');
        }

        return $this->render('message/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
