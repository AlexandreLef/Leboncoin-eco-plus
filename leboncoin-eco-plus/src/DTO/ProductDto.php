<?php

namespace App\DTO;

use App\Entity\AbstractEntity;
use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;

class ProductDto extends AbstractDto  {

	#[Assert\NotBlank]
	#[Assert\Length(max: 255)]
    private string $name;

    #[Assert\NotBlank]
    #[Assert\Length(max: 2048)]
    public string $description;

    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    #[Assert\LessThanOrEqual(100000)]
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
     * @return string
     */
    public function getName(): string {
        return $this->name;
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
    public function getPrice(): float {
        return $this->price;
    }

    /**
     * @return array
     */
    public function getImages(): array {
        return $this->images;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void {
        $this->price = $price;
    }

    /**
     * @param array $images
     */
    public function setImages(array $images): void {
        $this->images = $images;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void {
        $this->category = $category;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category {
        return $this->category;
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

    /**
     * @param AbstractEntity $entity
     */
	public function setFromEntity(AbstractEntity $entity): void {
        /** @var Product $entity */
        $this->name = $entity->getName();
        $this->price = $entity->getPrice();
        $this->description = $entity->getDescription();
        $this->category = $entity->getCategory();
        $this->quality = $entity->getQuality();
        $this->city = $entity->getCity();
	}
}
