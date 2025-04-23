<?php

namespace App\Repository;

use App\Entity\TaskEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaskEntry>
 *
 * @method TaskEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskEntry[]    findAll()
 * @method TaskEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskEntry::class);
    }

//    /**
//     * @return TaksEntry[] Returns an array of TaksEntry objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TaksEntry
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
