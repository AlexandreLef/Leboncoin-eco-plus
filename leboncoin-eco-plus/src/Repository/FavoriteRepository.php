<?php

namespace App\Repository;

use App\Entity\Favorite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Favorite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favorite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favorite[]    findAll()
 * @method Favorite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {parent::__construct($registry, Favorite::class);}

    public function add(Favorite $entity, bool $flush = true): void {
        $this->_em->persist($entity);
        if ($flush) {$this->_em->flush();}
    }

    public function remove(Favorite $entity, bool $flush = true): void {
        $this->_em->remove($entity);
        if ($flush) {$this->_em->flush();}
    }

    public function save(Favorite $favorite): void {
        $this->getEntityManager()->persist($favorite);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws EntityNotFoundException
     */
    public function delete(Favorite $favorite): void {
        if (!$favorite) {throw new EntityNotFoundException('Entity not found');}
        $this->getEntityManager()->remove($favorite);
        $this->getEntityManager()->flush();
    }
}
