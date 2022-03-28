<?php

namespace App\Service;

use App\DTO\AbstractDto;
use App\DTO\CategoryDto;
use App\Entity\AbstractEntity;
use App\Repository\CategoryRepository;
use JetBrains\PhpStorm\Pure;
use Proxies\__CG__\App\Entity\Category;

class CategoryService extends AbstractEntityService
{

    #[Pure] public function __construct(CategoryRepository $categoryRepository)
    {
        parent::__construct($categoryRepository);
    }

    /**
     * @param CategoryDto $dto
     * @param Category $entity
     */
    public function addOrUpdate(AbstractDto $dto, AbstractEntity $entity): void
    {
        parent::addOrUpdate($dto, $entity);
    }
}