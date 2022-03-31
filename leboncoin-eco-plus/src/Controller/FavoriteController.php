<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\FavoriteRepository;
use DateTime;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function addOrRemove(FavoriteRepository $favoriteRepository, Product $product, Request $request):
    Response {
        $user = $this->getUser(); /** @var User $user */
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
        $url = $request->headers->get('referer');
        return $this->redirect($url);
    }

    #[Route('/favorite/add/product/{id}', name: 'favorite_add')]
    public function add(FavoriteRepository $favoriteRepository, Product $product, Request $request): Response {
        $user = $this->getUser(); /** @var User $user */
        $favorite = new Favorite();
        $favorite->setUser($user);
        $favorite->setProduct($product);
        $favorite->setDate(new DateTime());
        $favoriteRepository->save($favorite);
        $url = $request->headers->get('referer');
        return $this->redirect($url);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/favorite/delete/{id}/return?{url}', name: 'favorite_delete')]
    public function delete(FavoriteRepository $favoriteRepository, Favorite $favorite, Request $request): Response {
        $favoriteRepository->delete($favorite);
        $url = $request->headers->get('referer');
        return $this->redirect($url);
    }
}
