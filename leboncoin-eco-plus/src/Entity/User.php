<?php

namespace App\Entity;

use App\DTO\AbstractDto;
use App\DTO\UserDto;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User extends AbstractEntity implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

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

    /**
     * @param UserDto $dto
     */
    public function setFromDto(UserDto|AbstractDto $dto): void
    {
        $this->setName($dto->getName());
        $this->setFirstname($dto->getFirstname());
        $this->setEmail($dto->getEmail());
        if ($dto->getPassword()) $this->setPassword($dto->getPassword());
        if ($dto->getAddress()) $this->setAddress($dto->getAddress());
        if ($dto->getZipcode()) $this->setZipcode($dto->getZipcode());
        if ($dto->getState()) $this->setState($dto->getState());
        $this->setRoles('ROLE_USER');
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(?int $zipcode): self
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;
        return $this;
    }

    public function getRoles(): array
    {
        return [$this->roles];
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
}
