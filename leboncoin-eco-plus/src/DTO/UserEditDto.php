<?php

namespace App\DTO;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class UserEditDto
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 250)]
    private string $lastname;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $firstname;

    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    private ?string $address = null;
    private ?int $zipcode = null;
    private ?string $state = null;

    public function setFromEntity(User $user): void {
        $this->lastname = $user->getLastname();
        $this->firstname = $user->getFirstname();
        $this->email = $user->getEmail();
        $this->address = $user->getAddress();
        $this->zipcode = $user->getZipcode();
        $this->state = $user->getState();
    }

    public function setEntityFromDto(User $user): void {
        if ($this->lastname) $user->setLastname($this->lastname);
        if ($this->firstname) $user->setFirstname($this->firstname);
        if ($this->email) $user->setEmail($this->email);
        if ($this->address) $user->setAddress($this->address);
        if ($this->zipcode) $user->setZipcode($this->zipcode);
        if ($this->state) $user->setState($this->state);
    }

    public function getLastname(): string {return $this->lastname;}
    public function setLastname(string $lastname): void {$this->lastname = $lastname;}

    public function getFirstname(): string {return $this->firstname;}
    public function setFirstname(string $firstname): void {$this->firstname = $firstname;}

    public function getEmail(): string {return $this->email;}
    public function setEmail(string $email): void {$this->email = $email;}

    public function getAddress(): ?string {return $this->address;}
    public function setAddress(?string $address): void {$this->address = $address;}

    public function getZipcode(): ?int {return $this->zipcode;}
    public function setZipcode(?int $zipcode): void {$this->zipcode = $zipcode;}

    public function getState(): ?string {return $this->state;}
    public function setState(?string $state): void {$this->state = $state;}
}