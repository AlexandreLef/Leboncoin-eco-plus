<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController {
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
}
