<?php

namespace App\Service;

use App\DTO\ProductDto;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityNotFoundException;
use JetBrains\PhpStorm\Pure;
use Transliterator;

class ProductService {
    #[Pure] public function __construct(private ProductRepository $productRepository) {}

    public function addOrUpdate(ProductDto $dto, Product $product): void {
        $dto->setEntityFromDto($product);
        $this->productRepository->save($product);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function delete(Product $product): void {
        $this->productRepository->delete($product);
    }

    /**
     * Remove all accents, trim spaces and lower case a string
     * @param string $value input string
     * @return string normalized string
     */
    public function normalize(string $value): string {
        // Use Transliterator to remove accents from a string
        $transliterator = Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC');
        return $transliterator->transliterate(trim(mb_strtolower($value)));
    }
}