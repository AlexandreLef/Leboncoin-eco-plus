<?php

namespace App\DTO;

use App\Entity\AbstractEntity;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class UserDto extends AbstractDto
{

    #[Assert\NotBlank]
    #[Assert\Length(max: 250)]
    private string $name;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $firstname;

    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[Assert\NotBlank(groups: ["add"])]
    private ?string $password = null;

    #[Assert\NotBlank(groups: ["add"])]
    private ?string $passwordConfirm = null;

    private ?string $address = null;
    private ?int $zipcode = null;
    private ?string $state = null;

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
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }

    /**
     * @param string|null $passwordConfirm
     */
    public function setPasswordConfirm(?string $passwordConfirm): void
    {
        $this->passwordConfirm = $passwordConfirm;
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


    /**
     * @param User|AbstractEntity $user
     */
    public function setFromEntity(User|AbstractEntity $user): void
    {
        $this->address = $user->getAddress();
        $this->name = $user->getName();
        $this->firstname = $user->getFirstname();
        $this->email = $user->getEmail();
        $this->password = $user->getPassword();
        $this->address = $user->getAddress();
        $this->zipcode = $user->getZipcode();
        $this->state = $user->getState();
    }
}
