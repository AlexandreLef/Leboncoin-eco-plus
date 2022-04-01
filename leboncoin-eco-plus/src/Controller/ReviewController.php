<?php

namespace App\Controller;

use App\DTO\ReviewDto;
use App\Entity\Review;
use App\Entity\User;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use DateTime;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController {

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route("/review/rate/{id}", name: "review_create", methods: ['GET', 'POST'])]
    public function rate(Request $request, User $user, ReviewRepository $reviewRepository): Response {
        $this->denyAccessUnlessGranted('add', $user);

        /** @var User $self */ $self = $this->getUser();
        $reviewDto = new ReviewDto();
        $form = $this->createForm(ReviewType::class, $reviewDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review = new Review();
            $reviewDto->setEntityFromDto($review);
            $review->setUser($user);
            $review->setReviewer($self);
            $review->setDate(new DateTime());
            $reviewRepository->add($review);
            return $this->redirectToRoute('home');
        }
        return $this->render('review/create.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    #[Route("/review/user/{id}", name: "review_list", methods: 'GET')]
    public function userReviews(User $user, Request $request): Response {
        $url = $request->headers->get('referer');
        $reviews = $user->getReviews();
        $self = $this->getUser(); /** @var User $self */
        if ($self) $selfConnected = $this->getUser() === $user;
        else $selfConnected = false;
        return $this->render('review/list.html.twig', [
            'back' => $url,
            'reviews' => $reviews,
            'selfConnected' => $selfConnected,
            'user' => $user
        ]);
    }
}
