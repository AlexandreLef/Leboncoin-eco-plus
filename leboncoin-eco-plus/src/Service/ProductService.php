<?php

namespace App\Service;

use App\DTO\ProductDto;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityNotFoundException;
use JetBrains\PhpStorm\Pure;

class ProductService
{
    #[Pure] public function __construct(private ProductRepository $productRepository)
    {
    }

    /**
     * @param ProductDto $dto
     * @param Product $product
     */
    public function addOrUpdate(ProductDto $dto, Product $product): void
    {
        $dto->setEntityFromDto($product);
        $this->productRepository->save($product);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function delete(Product $product): void
    {
        $this->productRepository->delete($product);
    }
}