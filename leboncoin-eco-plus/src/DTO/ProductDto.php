<?php

namespace App\DTO;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;

class ProductDto {
    #[Assert\NotBlank]
    #[Assert\Length(max: 4096)]
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

    public function setFromEntity(Product $product): void {
        $this->name = $product->getName();
        $this->price = $product->getPrice();
        $this->description = $product->getDescription();
        $this->category = $product->getCategory();
        $this->quality = $product->getQuality();
        $this->city = $product->getCity();
    }

    public function setEntityFromDto(Product $product): void {
        if ($this->name) $product->setName($this->name);
        if ($this->price) $product->setPrice(intval($this->price * 100));
        if ($this->description) $product->setDescription($this->description);
        $product->setCategory($this->category);
        if ($this->quality) $product->setQuality($this->quality);
        if ($this->city) $product->setCity($this->city);
    }

    public function getName(): string {return $this->name;}
    public function setName(string $name): void {$this->name = $name;}

    public function getCity(): string {return $this->city;}
    public function setCity(string $city): void {$this->city = $city;}

    public function getPrice(): float {return $this->price;}
    public function setPrice(float $price): void {$this->price = $price;}

    public function getImages(): array {return $this->images;}
    public function setImages(array $images): void {$this->images = $images;}

    public function getDescription(): string {return $this->description;}
    public function setDescription(string $description): void {$this->description = $description;}

    public function getCategory(): Category {return $this->category;}
    public function setCategory(Category $category): void {$this->category = $category;}

    public function getQuality(): int {return $this->quality;}
    public function setQuality(int $quality): void {$this->quality = $quality;}
}