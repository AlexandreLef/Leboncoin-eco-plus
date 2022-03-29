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

    public function index(Request $request, CategoryRepository $categoryRepository, ProductRepository $productRepository, ProductService $productService): Response {
        // Manage form
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $products = $productService->getProductsBySearch($form, $productRepository);
            return $this->render('product/list.html.twig', [
                'form' => $form->createView(),
                'products' => $products,
                'categories' => $categoryRepository->findAll(),
                'total' => count($products),
                'selectedCategoryId' => -1,
                'search' => '',
                'city' => '',
            ]);
        }
        else {
            return $this->render('home/index.html.twig', ['categories' => $categoryRepository->findAll()]);
        }
    }
}
