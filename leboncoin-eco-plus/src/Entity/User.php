<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id = -1;

    #[ORM\Column(type: 'string', length: 255)]
    private string $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    private string $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $address;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $zipcode;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $state;

    #[ORM\Column(type: 'string', length: 255)]
    private string $roles;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Product::class, orphanRemoval: true)]
    private Collection $products;

    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $creation;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Favorite::class, orphanRemoval: true)]
    private Collection $favorites;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Search::class, orphanRemoval: true)]
    private Collection $searches;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Message::class)]
    private $messages;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Review::class, orphanRemoval: true)]
    private $reviews;

    #[Pure] public function __construct() {
        $this->products = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->searches = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): int {return $this->id;}

    public function getLastname(): string {return $this->lastname;}
    public function setLastname(string $lastname): self {$this->lastname = $lastname;return $this;}

    public function getFirstname(): string {return $this->firstname;}
    public function setFirstname(string $firstname): self {$this->firstname = $firstname;return $this;}

    public function getPassword(): string {return $this->password;}
    public function setPassword(string $password): self {$this->password = $password;return $this;}

    public function getAddress(): ?string {return $this->address;}
    public function setAddress(?string $address): self {$this->address = $address;return $this;}

    public function getZipcode(): ?int {return $this->zipcode;}
    public function setZipcode(int $zipcode): self {$this->zipcode = $zipcode;return $this;}

    public function getState(): ?string {return $this->state;}
    public function setState(string $state): self {$this->state = $state;return $this;}

    public function getRoles(): array {return [$this->roles];}
    public function setRoles(string $roles): self {$this->roles = $roles;return $this;}

    public function eraseCredentials() {}

    public function getUserIdentifier(): string {return $this->getEmail();}

    public function getEmail(): string {return $this->email;}
    public function setEmail(string $email): self {$this->email = $email;return $this;}

    public function getProducts(): Collection { return $this->products; }
    public function addProduct(Product $product): self {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setUser($this);
        }
        return $this;
    }
    public function removeProduct(Product $product): self {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getUser() === $this) {
                $product->setUser(null);
            }
        }
        return $this;
    }

    public function getCreation(): ?DateTimeInterface {return $this->creation;}
    public function setCreation(DateTimeInterface $creation): self {$this->creation = $creation;return $this;}

    public function getFavorites(): Collection {return $this->favorites;}
    public function addFavorite(Favorite $favorite): self {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->setUser($this);
        }
        return $this;
    }
    public function removeFavorite(Favorite $favorite): self {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getUser() === $this) {
                $favorite->setUser(null);
            }
        }
        return $this;
    }

    public function getSearches(): Collection {return $this->searches;}
    public function addSearch(Search $search): self {
        if (!$this->searches->contains($search)) {
            $this->searches[] = $search;
            $search->setUser($this);
        }
        return $this;
    }
    public function removeSearch(Search $search): self {
        if ($this->searches->removeElement($search)) {
            // set the owning side to null (unless already changed)
            if ($search->getUser() === $this) {
                $search->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection {return $this->messages;}
    public function addMessage(Message $message): self{
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setSender($this);
        }
        return $this;
    }
    public function removeMessage(Message $message): self {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection {return $this->reviews;}
    public function addReview(Review $review): self {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setUser($this);
        }
        return $this;
    }
    public function removeReview(Review $review): self {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUser() === $this) {
                $review->setUser(null);
            }
        }
        return $this;
    }

    #[ArrayShape(['avg' => "float|int|null", 'number' => "int", 'canRate' => "bool"])]
    public function getRate(ReviewRepository $reviewRepository, User $reviewer = null): array {
        $reviews = $this->getReviews();
        $rates = [];
        $rateNumber = 0;
        $avg = null;
        $canRate = null;

        if ($reviews) {
            foreach ($reviews as $review) {$rates[] = $review->getRate();}
            $rates = array_filter($rates);
            $rateNumber = count($rates);
            $avg = (count($rates)) ? array_sum($rates)/count($rates) : null;
        }

        if ($reviewer) {
            $test = $reviewRepository->findOneBy(['user' => $this, 'reviewer' => $reviewer]);
            $canRate = $test == null;
        }

        return ['avg' =>$avg, 'number' => $rateNumber, 'canRate' => $canRate];
    }
}
