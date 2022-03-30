<?php

namespace App\Service;

use App\DTO\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserService {
    private UserPasswordHasherInterface $passwordHasher;

    #[Pure] public function __construct(UserPasswordHasherInterface $passwordHasher, private UserRepository $userRepository){$this->passwordHasher = $passwordHasher;}

    public function addOrUpdate($dto, User $user): void{
        $userWithNewMail = $this->userRepository->findByEmail($dto->getEmail());
        if ($userWithNewMail && $userWithNewMail->getId() !== $user->getId()) {throw new Exception('Il y a déjà un utilisateur avec cette adresse mail');}
        if ($dto instanceof UserDto && $dto->getPassword()) {$dto->setPassword($this->encodePassword($user, $dto->getPassword()));}
        $dto->setEntityFromDto($user);
        $this->userRepository->save($user);
    }

    public function encodePassword(PasswordAuthenticatedUserInterface $user, string $value): string {return $this->passwordHasher->hashPassword($user, $value);}

    public function isPasswordValid(PasswordAuthenticatedUserInterface $user, string $value): bool {return $this->passwordHasher->isPasswordValid($user, $value);}

    /**
     * @throws EntityNotFoundException
     */
    public function delete(User $user): void {$this->userRepository->delete($user);}
}