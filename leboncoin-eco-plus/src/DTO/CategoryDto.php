<?php

namespace App\DTO;

use App\Entity\AbstractEntity;
use App\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryDto extends AbstractDto
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
     * @param Category $entity
     */
    public function setFromEntity(AbstractEntity $entity): void
    {
        $this->name = $entity->getName();
    }
}
