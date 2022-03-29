<?php

namespace App\DTO;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class UserModifyDto
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

    /**
     * @param User $user
     */
    public function setFromEntity(User $user): void
    {
        $this->lastname = $user->getLastname();
        $this->firstname = $user->getFirstname();
        $this->email = $user->getEmail();
        $this->address = $user->getAddress();
        $this->zipcode = $user->getZipcode();
        $this->state = $user->getState();
    }

    /**
     * @param User $user
     */
    public function setEntityFromDto(User $user): void
    {
        if ($this->lastname) $user->setLastname($this->lastname);
        if ($this->firstname) $user->setFirstname($this->firstname);
        if ($this->email) $user->setEmail($this->email);
        if ($this->address) $user->setAddress($this->address);
        if ($this->zipcode) $user->setZipcode($this->zipcode);
        if ($this->state) $user->setState($this->state);
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return int|null
     */
    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    /**
     * @param int|null $zipcode
     */
    public function setZipcode(?int $zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }
}
