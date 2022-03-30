<?php

namespace App\Controller;

use App\Repository\FavoriteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'favorite')]
    public function index(FavoriteRepository $favoriteRepository): Response
    {
        $favorites = $favoriteRepository->findBy([
            'user' => $this->getUser(),
        ]);

        return $this->render('favorite/index.html.twig', [
            'controller_name' => 'FavoriteController',
            'favorites' => $favorites
        ]);
    }
}
