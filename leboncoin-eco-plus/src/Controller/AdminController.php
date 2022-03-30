<?php

namespace App\Controller;

use App\DTO\CategoryDto;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Service\CategoryService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/category', name: 'admin_category')]
    public function category(CategoryRepository $categoryRepository): Response
    {

        return $this->render('admin/category.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/admin/category/add', name: 'admin_category_add', methods: ['GET', 'POST'])]
    public function create(Request $request, CategoryService $categoryService): Response
    {
        $categoryDto = new CategoryDto();

        $form = $this->createForm(CategoryType::class, $categoryDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = new Category();
            $categoryDto->setEntityFromDto($category);
            $categoryService->addOrUpdate($categoryDto, $category);

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/category_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/admin/category/delete/{id}', name: 'admin_category_delete', methods: ['GET', 'POST'])]
    public function delete(CategoryRepository $categoryRepository, Category $category): Response
    {
        $categoryRepository->delete($category);
        return $this->redirectToRoute('admin_category');
    }
}
