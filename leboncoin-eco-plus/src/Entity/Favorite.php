<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = -1;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'favorites')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'favorites')]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    #[ORM\Column(type: 'date')]
    private DateTime $date;

    public function getId(): int {return $this->id;}

    public function getUser(): User {return $this->user;}
    public function setUser(User $user): self {$this->user = $user;return $this;}

    public function getProduct(): Product {return $this->product;}
    public function setProduct(Product $product): self {$this->product = $product;return $this;}

    public function getDate(): DateTime {return $this->date;}
    public function setDate(DateTime $date): self{$this->date = $date;return $this;}
}