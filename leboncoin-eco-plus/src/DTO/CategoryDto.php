<?php

namespace App\DTO;

use App\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryDto
{

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $name;

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
     * @param Category $category
     */
    public function setFromEntity(Category $category): void
    {
        $this->name = $category->getName();
    }

    /**
     * @param Category $category
     */
    public function setEntityFromDto(Category $category): void
    {
        if ($this->name) $category->setName($this->name);
    }
}
