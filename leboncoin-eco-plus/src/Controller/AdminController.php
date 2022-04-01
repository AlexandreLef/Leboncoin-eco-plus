<?php

namespace App\Controller;

use App\DTO\CategoryDto;
use App\DTO\ProductDto;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\CategoryService;
use App\Service\ProductService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController {
    #[Route('/admin', name: 'admin')]
    public function index(): Response {return $this->render('admin/index.html.twig', ['controller_name' => 'AdminController',]);}

    #[Route('/admin/category', name: 'admin_category')]
    public function category(Request $request, CategoryService $categoryService, CategoryRepository $categoryRepository): Response {
        $categoryDto = new CategoryDto();
        $form = $this->createForm(CategoryType::class, $categoryDto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = new Category();
            $categoryDto->setEntityFromDto($category);
            $categoryService->addOrUpdate($categoryDto, $category);
            return $this->redirectToRoute('admin_category');
        }
        return $this->render('admin/category.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/category/edit/{id}/name/{name}', name: 'admin_category_edit', methods: 'GET')]
    public function editCategory (CategoryService $categoryService, Category $category, CategoryDto $categoryDto, string $name): Response {
        $categoryDto->setName($name);
        $categoryService->addOrUpdate($categoryDto, $category);
        return $this->redirectToRoute('admin_category');
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/admin/category/delete/{id}', name: 'admin_category_delete', methods: 'GET')]
    public function deleteCategory (CategoryRepository $categoryRepository, Category $category): Response {
        $categoryRepository->delete($category);
        return $this->redirectToRoute('admin_category');
    }

    #[Route('/admin/product', name: 'admin_product')]
    public function product(Request $request, ProductService $productService, ProductRepository $productRepository): Response {
        $productDto = new ProductDto();
        $form = $this->createForm(ProductType::class, $productDto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = new Product();
            $productDto->setEntityFromDto($product);
            $productService->addOrUpdate($productDto, $product);
            return $this->redirectToRoute('admin_product');
        }
        return $this->render('admin/product.html.twig', [
            'products' => $productRepository->findBy([], ['date' => 'DESC']),
            'form' => $form->createView()
        ]);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/admin/product/delete/{id}', name: 'admin_product_delete', methods: 'GET')]
    public function deleteProduct (ProductRepository $productRepository, Product $product): Response {
        $productRepository->delete($product);
        return $this->redirectToRoute('admin_product');
    }
}
