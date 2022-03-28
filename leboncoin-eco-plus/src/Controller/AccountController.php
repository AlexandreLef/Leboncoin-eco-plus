<?php

namespace App\Controller;

use App\DTO\UserDto;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\LoginType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AccountController extends AbstractController {
    private UserService $userService;
	private TokenStorageInterface $tokenStorage;

	public function __construct(UserService $userService, TokenStorageInterface $tokenStorage) {
    $this->userService = $userService;
    $this->tokenStorage = $tokenStorage;
    }


    #[Route('/account', name: 'account')]
    public function index(): Response {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    #[Route('/account/login', name: 'account_login')]
    public function login(Request $request): Response {

        $form = $this->createForm(
            LoginType::class,
        );

        if ($form->isSubmitted() && $form->isValid()) {
            error_log('valid');
        }

        return $this->render('account/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/account/create', name: 'account_create', methods: ['GET','POST'])]
    public function create(Request $request): Response
    {

        /** @var User $user */
        $user = $this->getUser();
        if ($user) {
            return $this->redirectToRoute('home');
        }

        $userDto = new UserDto();

        $form = $this->createForm(AccountType::class, $userDto, ['validation_groups' => ['Default', 'add']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user->setFromDto($userDto);
            $this->userService->addOrUpdate($userDto, $user);

            return $this->redirectToRoute('home');
        }

        return $this->render('account/create.html.twig', [
            'form' => $form->createView(),
            'isAdd' => true
        ]);
    }

}
