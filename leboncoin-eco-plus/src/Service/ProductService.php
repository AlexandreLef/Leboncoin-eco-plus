<?php

namespace App\Service;

use App\DTO\ProductDto;
use App\DTO\SearchDto;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityNotFoundException;
use JetBrains\PhpStorm\Pure;
use Transliterator;

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

    public function getProductsBySearch($form, $productRepository) {
        $transliterator = Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC');
        /** @var SearchDto $searchDto */
        $searchDto = $form->getData();
        $categoryId = $searchDto->getCategory()?->getId();
        $search = $transliterator->transliterate(mb_strtolower($searchDto->getSearch()));
        $city = $transliterator->transliterate(mb_strtolower($searchDto->getCity()));
        if ($categoryId) $tmpProducts = $productRepository->findBy(['category' => $searchDto->getCategory()]);
        else $tmpProducts = $productRepository->findAll();
        $products = [];
        foreach ($tmpProducts as $product) {
            $tmpName = $transliterator->transliterate(mb_strtolower($product->getName()));
            $tmpCity = $transliterator->transliterate(mb_strtolower($product->getCity()));
            if ($search == '' && $city != '') {
                if (str_contains($tmpCity, $city)) $products[] = $product;
            } else if ($search != '' && $city == '') {
                if (str_contains($tmpName, $search)) $products[] = $product;
            } else {
                $products[] = $product;
            }
        }
        return $products;
    }
}