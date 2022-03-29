<?php

namespace App\Service;

use App\DTO\CategoryDto;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityNotFoundException;
use JetBrains\PhpStorm\Pure;
use Proxies\__CG__\App\Entity\Category;

class CategoryService
{

    #[Pure] public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    /**
     * @param CategoryDto $dto
     * @param Category $category
     */
    public function addOrUpdate(CategoryDto $dto, Category $category): void
    {
        $dto->setEntityFromDto($category);
        $this->categoryRepository->save($category);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category);
    }
}