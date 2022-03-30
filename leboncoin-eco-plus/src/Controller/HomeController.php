<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    #[Route('/', name: 'home')]
    public function index(Request $request, CategoryRepository $categoryRepository, ProductRepository $productRepository): Response {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $products = $productRepository->findAll();

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'categories' => $categoryRepository->findAll(),
            'total' => count($products),
            'selectedCategoryId' => -1,
            'search' => '',
            'city' => '',
            'userSearches' => $this->getUser()->getSearches()
        ]);
    }
}
