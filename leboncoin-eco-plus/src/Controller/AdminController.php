<?php

namespace App\Controller;

use App\DTO\CategoryDto;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private CategoryService $categoryService;

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    // TODO correction of adding on submit button click
    #[Route('/admin/category/add', name: 'admin_category_add', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $categoryDto = new CategoryDto();

        $form = $this->createForm(CategoryType::class, $categoryDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = new Category();
            $category->setFromDto($categoryDto);
            $this->categoryService->addOrUpdate($categoryDto, $category);

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/category_add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
