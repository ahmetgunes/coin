<?php

namespace App\Repository;

use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function getUserBalance(int $userId)
    {
        $query = 'SELECT SUM(amount) AS sum FROM transaction WHERE user_id = ?';

        $result = $this->_em->getConnection()->fetchAssoc($query, [$userId]);

        return $result['sum'];
    }
}
