<?php

namespace App\Repository;

use App\Entity\RecentContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecentContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecentContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecentContact[]    findAll()
 * @method RecentContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecentContactRepository extends ServiceEntityRepository
{
    public const COOLDOWN_IN_SECS = 900; // 15 * 60;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecentContact::class);
    }

    /**
     * @return RecentContact[] Returns an array of RecentContact objects for a specific IP address
     */
    public function findLatestByIp(string $ip): array
    {
        $entityManager = $this->getEntityManager();

        $cooldown = (new \DateTime())->getTimestamp() - self::COOLDOWN_IN_SECS;

        return $this->createQueryBuilder('rc')
            ->andWhere('rc.ip = :ip')
            ->andWhere('rc.sent_at > :cooldown')
            ->setParameter('ip', $ip)
            ->setParameter('cooldown', $cooldown)
            ->orderBy('rc.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
}
