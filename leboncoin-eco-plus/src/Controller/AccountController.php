<?php

namespace App\Controller;

use App\DTO\UserDto;
use App\DTO\UserModifyDto;
use App\Entity\User;
use App\Form\LoginType;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\RuntimeException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    private UserService $userService;
    private TokenStorageInterface $tokenStorage;

    public function __construct(UserService $userService, TokenStorageInterface $tokenStorage)
    {
        $this->userService = $userService;
        $this->tokenStorage = $tokenStorage;
    }


    #[Route('/account', name: 'account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    #[Route('/account/modify', name: 'account_modify')]
    public function modify(Request $request): Response
    {
        $userModifyDto = new UserModifyDto();
        $userModifyDto->setFromEntity($this->getUser());

        $form = $this->createForm(UserEditType::class, $userModifyDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $userModifyDto->setEntityFromDto($user);
            $this->userService->addOrUpdate($userModifyDto, $user);

            return $this->redirectToRoute('account');
        }

        return $this->render('account/modify.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }

    #[Route('/account/login', name: 'account_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $errors = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'error' => $errors,
            'last_username' => $lastUsername
        ]);
    }

    #[Route('/account/create', name: 'account_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {

        /** @var User $user */
        $user = $this->getUser();
        if ($user) {
            return $this->redirectToRoute('home');
        }

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
    public function logout(): void
    {
        throw new RuntimeException('Don\'t forget to activate logout in security.yaml');
    }


}
