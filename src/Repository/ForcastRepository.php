<?php

namespace App\Repository;

use App\Entity\Forcast;
use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Forcast>
 *
 * @method Forcast|null find($id, $lockMode = null, $lockVersion = null)
 * @method Forcast|null findOneBy(array $criteria, array $orderBy = null)
 * @method Forcast[]    findAll()
 * @method Forcast[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForcastRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Forcast::class);
    }

    public function findByLocation(Location $location){
        $qb = $this->createQueryBuilder('m');
        $qb->where('m.location = :location')
            ->setParameter('location', $location)
            ->andWhere('m.date > :now')
            ->setParameter('now', date('Y-m-d'));

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }

    public function findByCityAndCountryCode(string $city,?string $countryCode){
        $qb = $this->createQueryBuilder('f')
            ->leftJoin('f.location', 'l')
            ->where('l.city = :city')
            ->setParameter('city', $city);

        if ($countryCode) {
            $qb->andWhere('l.country = :tryCode')
                ->setParameter('countryCode', $countryCode);
        }

        $qb->andWhere('f.date > :now')
            ->setParameter('now', date('Y-m-d'));

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Forcast[] Returns an array of Forcast objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Forcast
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
