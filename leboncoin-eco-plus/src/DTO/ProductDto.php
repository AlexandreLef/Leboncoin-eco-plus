<?php

namespace App\DTO;

use App\Entity\AbstractEntity;
use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;

class ProductDto
{

    #[Assert\NotBlank]
    #[Assert\Length(max: 2048)]
    public string $description;
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $name;
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    #[Assert\LessThanOrEqual(100000000)]
    private float $price;

    private array $images;

    #[Assert\NotBlank]
    private Category $category;

    #[Assert\NotBlank]
    private int $quality;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $city;


    /**
     * @param Product $product
     */
    public function setFromEntity(Product $product): void
    {
        $this->name = $product->getName();
        $this->price = $product->getPrice();
        $this->description = $product->getDescription();
        $this->category = $product->getCategory();
        $this->quality = $product->getQuality();
        $this->city = $product->getCity();
    }

    /**
     * @param Product $product
     */
    public function setEntityFromDto(Product $product): void
    {
        if ($this->name) $product->setName($this->name);
        if ($this->price) $product->setPrice($this->price);
        if ($this->description) $product->setDescription($this->description);
        $product->setCategory($this->category);
        if ($this->quality) $product->setQuality($this->quality);
        if ($this->city) $product->setCity($this->city);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param array $images
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return int
     */
    public function getQuality(): int
    {
        return $this->quality;
    }

    /**
     * @param int $quality
     */
    public function setQuality(int $quality): void
    {
        $this->quality = $quality;
    }
}
