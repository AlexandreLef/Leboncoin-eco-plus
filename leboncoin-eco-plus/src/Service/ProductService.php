<?php

namespace App\Service;

use App\DTO\AbstractDto;
use App\Entity\AbstractEntity;
use App\Entity\User;
use App\Repository\ProductRepository;
use JetBrains\PhpStorm\Pure;

class ProductService extends AbstractEntityService
{


    #[Pure] public function __construct(ProductRepository $productRepository)
    {
        parent::__construct($productRepository);
    }

    /**
     * @param ProductDto $dto
     * @param User $entity
     */
    public function addOrUpdate(AbstractDto $dto, AbstractEntity $entity): void
    {

        parent::addOrUpdate($dto, $entity);
    }
}