<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $user, bool $flush = true): void
    {
        $this->_em->persist($user);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(User $user, bool $flush = true): void
    {
        $this->_em->remove($user);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws EntityNotFoundException
     */
    public function delete(User $user): void
    {
        if (!$user) {
            throw new EntityNotFoundException('Entity not found');
        }
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }
}
