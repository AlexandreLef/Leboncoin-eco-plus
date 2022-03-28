<?php

namespace App\DTO;

use App\Entity\AbstractEntity;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class UserDto extends AbstractDto  {

	#[Assert\NotBlank]
	#[Assert\Length(max: 250)]
	public string $name;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $firstname;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $username;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

	#[Assert\NotBlank(groups: ["add"])]
	public ?string $password = null;

	#[Assert\NotBlank(groups: ["add"])]
	public ?string $passwordConfirm = null;

	public ?string $address = null;

    public ?int $zipcode = null;

    public ?string $state = null;


    /**
     * @param AbstractEntity $user
     */
	public function setFromEntity(AbstractEntity $user): void {
        /** @var User $user */
        $this->address = $user->getAddress();
        $this->name    = $user->getName();
        $this->email    = $user->getEmail();
        $this->password = $user->getPassword();
        $this->address = $user->getAddress();
        $this->zipcode = $user->getZipcode();
        $this->state = $user->getState();
	}
}
