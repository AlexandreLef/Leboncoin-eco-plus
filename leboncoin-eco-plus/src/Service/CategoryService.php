<?php

namespace App\Service;

use App\DTO\CategoryDto;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityNotFoundException;
use JetBrains\PhpStorm\Pure;

class CategoryService {
    #[Pure] public function __construct(private CategoryRepository $categoryRepository) {}

    public function addOrUpdate(CategoryDto $dto, Category $category): void{
        $dto->setEntityFromDto($category);
        $this->categoryRepository->save($category);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function delete(Category $category): void {$this->categoryRepository->delete($category);}
}