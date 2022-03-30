<?php

namespace App\DTO;

use App\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;

class SearchDto {
    private Category $category;

    #[Assert\Length(max: 255)]
    private string $search = '';

    #[Assert\Length(max: 255)]
    private string $city = '';

    public function getCategory(): ?Category {return $this->category ?? null;}
    public function setCategory(Category $category): void {$this->category = $category;}

    public function getSearch(): string {return $this->search;}
    public function setSearch(string $search): void {$this->search = $search;}

    public function getCity(): string {return $this->city;}
    public function setCity(string $city): void {$this->city = $city;}
}