<?php

namespace App\DTO;

use App\Entity\AbstractEntity;
use App\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;

class SearchDto extends AbstractDto  {

    private Category $category;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $search;

    #[Assert\Length(max: 255)]
    private float $city;

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
     * @return string
     */
    public function getSearch(): string
    {
        return $this->search;
    }

    /**
     * @param string $search
     */
    public function setSearch(string $search): void
    {
        $this->search = $search;
    }

    /**
     * @return float
     */
    public function getCity(): float
    {
        return $this->city;
    }

    /**
     * @param float $city
     */
    public function setCity(float $city): void
    {
        $this->city = $city;
    }

    /**
     * @param AbstractEntity $entity
     */
    public function setFromEntity(AbstractEntity $entity): void {
        $this->category = $entity->getCategory();
        $this->search = $entity->getSearch();
        $this->city = $entity->getCity();
    }
}
