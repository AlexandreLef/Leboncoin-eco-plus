<?php

namespace App\Controller;

use App\DTO\ReviewDto;
use App\DTO\UserDto;
use App\DTO\UserEditDto;
use App\Entity\Review;
use App\Entity\User;
use App\Form\ReviewType;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Repository\ReviewRepository;
use App\Service\UserService;
use DateTime;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController {
    private UserService $userService;

    public function __construct(UserService $userService) {$this->userService = $userService;}

    #[Route('/account', name: 'account')]
    public function index(ReviewRepository $reviewRepository): Response {

        $user = $this->getUser(); /** @var User $user */
        $rate = $user->getRate($reviewRepository);

        return $this->render('account/index.html.twig', [
            'user' => $this->getUser(),
            'avg' => $rate['avg'],
            'rateNumber' => $rate['number']
        ]);
    }

    #[Route('/account/modify', name: 'account_modify')]
    public function modify(Request $request): Response {
        $user = $this->getUser(); /** @var User $user */
        $userModifyDto = new UserEditDto();
        $userModifyDto->setFromEntity($user);
        $form = $this->createForm(UserEditType::class, $userModifyDto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->addOrUpdate($userModifyDto, $user);
            return $this->redirectToRoute('account');
        }
        return $this->render('account/modify.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }

    #[Route('/account/login', name: 'account_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response {
        $errors = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('account/login.html.twig', [
            'error' => $errors,
            'last_username' => $lastUsername
        ]);
    }

    #[Route('/account/create', name: 'account_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response {
        /** @var User $user */ $user = $this->getUser();
        if ($user) {return $this->redirectToRoute('home');}
        $userDto = new UserDto();
        $form = $this->createForm(UserType::class, $userDto, ['validation_groups' => ['Default', 'add']]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $userDto->setEntityFromDto($user);
            $this->userService->addOrUpdate($userDto, $user);
            return $this->redirectToRoute('account_login');
        }
        return $this->render('account/create.html.twig', [
            'form' => $form->createView(),
            'isAdd' => true
        ]);
    }

    #[Route("/logout", name: "account_logout")]
    public function logout(): void {throw new RuntimeException('Don\'t forget to activate logout in security.yaml');}

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route("/account/rate/{id}", name: "account_rate", methods: ['GET', 'POST'])]
    public function rate(Request $request, User $user, ReviewRepository $reviewRepository): Response {
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

            $url = $request->headers->get('referer');
            return $this->redirect($url);
        }
        return $this->render('account/review.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
