<?php

namespace App\DTO;

use App\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryDto {
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $name;

    public function getName(): string {return $this->name;}
    public function setName(string $name): void {$this->name = $name;}

    public function setFromEntity(Category $category): void {$this->name = $category->getName();}
    public function setEntityFromDto(Category $category): void {if ($this->name) $category->setName($this->name);}
}