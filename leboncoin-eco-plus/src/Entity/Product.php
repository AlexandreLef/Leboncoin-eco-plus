<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id = -1;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $price;

    #[ORM\Column(type: 'string', length: 4096)]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    private ?Category $category;

    #[ORM\Column(type: 'integer')]
    private int $quality;

    #[ORM\Column(type: 'string', length: 255)]
    private string $city;

    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $date;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Favorite::class, orphanRemoval: true)]
    private $favorites;

    private array $imagesPath;

    #[Pure] public function __construct() {
        $this->favorites = new ArrayCollection();
        $this->imagesPath = [];
    }

    public function getImagesPath(): array {
        if(!isset($this->imagesPath)) {
            // Get all images
            $directory = '/assets/img/products/' . $this->getId() . '/';
            if (file_exists('.' . $directory)) {
                $scannedDirectory = array_diff(scandir('.' . $directory), array('..', '.'));
                foreach($scannedDirectory as $image) $this->imagesPath[] = $directory . $image;
            }
            else { $this->imagesPath = ['/assets/img/no-image.png']; }
        }
        return $this->imagesPath;
    }

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }

    public function getPrice(): ?int { return $this->price; }
    public function setPrice(int $price): self { $this->price = $price; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }

    public function getCategory(): ?Category { return $this->category; }
    public function setCategory(?Category $category): self { $this->category = $category; return $this; }

    public function getQuality(): ?int { return $this->quality; }
    public function setQuality(int $Quality): self { $this->quality = $Quality; return $this; }

    public function getCity(): ?string { return $this->city; }
    public function setCity(string $city): self { $this->city = $city; return $this; }

    public function getDate(): ?DateTimeInterface { return $this->date; }
    public function setDate(DateTimeInterface $date): self { $this->date = $date; return $this; }

    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): self { $this->user = $user; return $this; }

    public function getFavorites(): Collection { return $this->favorites; }
    public function addFavorite(Favorite $favorite): self {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->setProduct($this);
        }
        return $this;
    }
    public function removeFavorite(Favorite $favorite): self {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getProduct() === $this) {
                $favorite->setProduct(null);
            }
        }
        return $this;
    }
}
