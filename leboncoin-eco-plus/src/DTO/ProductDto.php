<?php

namespace App\DTO;

use App\Entity\AbstractEntity;
use App\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;

class ProductDto extends AbstractDto  {

	#[Assert\NotBlank]
	#[Assert\Length(max: 255)]
	public string $name;

    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    #[Assert\LessThanOrEqual(1000)]
    public string $price;

    #[Assert\File]
    public string $images;

    #[Assert\NotBlank]
    #[Assert\Length(max: 2048)]
    public string $description;

    /**
     * @param AbstractEntity $entity
     */
	public function setFromEntity(AbstractEntity $entity): void {
        /** @var Product $entity */
        $this->name = $entity->getName();
        $this->price = $entity->getPrice();
        $this->images = $entity->getImages();
        $this->description = $entity->getDescription();
	}
}
