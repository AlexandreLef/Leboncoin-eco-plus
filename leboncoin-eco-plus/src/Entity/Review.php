<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $rate;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $reviewer;

    #[ORM\Column(type: 'text', nullable: true)]
    private $comment;

    #[ORM\Column(type: 'date')]
    private DateTime $date;

    public function getId(): ?int {return $this->id;}

    public function getRate(): ?int {return $this->rate;}
    public function setRate(int $rate): self {$this->rate = $rate;return $this;}

    public function getUser(): ?User {return $this->user;}
    public function setUser(?User $user): self {$this->user = $user;return $this;}

    public function getReviewer(): ?User {return $this->reviewer;}
    public function setReviewer(?User $reviewer): self {$this->reviewer = $reviewer;return $this;}

    public function getComment(): ?string {return $this->comment;}
    public function setComment(?string $comment): self {$this->comment = $comment;return $this;}

    public function getDate(): ?DateTime {return $this->date;}
    public function setDate(DateTime $date): self {$this->date = $date;return $this;}
}
