<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Entity\Product;
use App\Repository\FavoriteRepository;
use DateTime;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController {
    #[Route('/favorite', name: 'favorite')]
    public function index(FavoriteRepository $favoriteRepository): Response {
        $favorites = $favoriteRepository->findBy(['user' => $this->getUser()]);
        return $this->render('favorite/index.html.twig', [
            'controller_name' => 'FavoriteController',
            'favorites' => $favorites
        ]);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/favorite/adding/product/{id}', name: 'favorite_add_remove')]
    public function addOrRemove(FavoriteRepository $favoriteRepository, Product $product): Response {
        $user = $this->getUser();
        if ($favorite = $favoriteRepository->findOneBy([
            'user' => $user,
            'product' => $product
        ])) {$favoriteRepository->delete($favorite);}
        else {
            $favorite = new Favorite();
            $favorite->setUser($user);
            $favorite->setProduct($product);
            $favorite->setDate(new DateTime());
            $favoriteRepository->save($favorite);
        }
        return $this->redirectToRoute('product_list');
    }

    #[Route('/favorite/add/product/{id}', name: 'favorite_add')]
    public function add(FavoriteRepository $favoriteRepository, Product $product): Response {
        $user = $this->getUser();
        $favorite = new Favorite();
        $favorite->setUser($user);
        $favorite->setProduct($product);
        $favorite->setDate(new DateTime());
        $favoriteRepository->save($favorite);
        return $this->redirectToRoute('product_list');
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/favorite/delete/{id}', name: 'favorite_delete')]
    public function delete(FavoriteRepository $favoriteRepository, Favorite $favorite): Response {
        $favoriteRepository->delete($favorite);
        return $this->redirectToRoute('favorite');
    }
}
