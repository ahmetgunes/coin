<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 3.03.2018
 * Time: 19:40
 */

namespace App\Bundles\CoinBundle\Models;


use App\Bundles\CoinBundle\Models\Exception\InvalidHashException;
use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;

class CoinTransaction
{
    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * CoinTransaction constructor.
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param User $user
     * @return string
     */
    public function buy(User $user)
    {
        $history = $this->getTransactionHistory();

        $miner = new Miner();

        list($hash, $amount) = $miner->mine($history);

        $transaction = new Transaction();
        $transaction->setUser($user);
        $transaction->setAmount($amount);
        $transaction->setHash($hash);

        $this->doctrine->getManager()->persist($transaction);
        $this->doctrine->getManager()->flush();

        return $hash;
    }

    /**
     * @param string $hash
     * @return int
     * @throws InvalidHashException
     */
    public function verify(string $hash)
    {
        if (strlen($hash) != Miner::COUNT) {
            throw new InvalidHashException();
        }

        if (!$this->checkHash($hash)) {
            throw new InvalidHashException();
        }

        $history = $this->getPreviousTransactionHistory($hash);

        $miner = new Miner();
        return $miner->verify($hash, $history);
    }

    /**
     * @return mixed
     *
     * Returns all the history of transactions (e.g. the ledger)
     *
     * Returned data is in the form of id1,user_id1,amount1|id2...
     */
    private function getTransactionHistory()
    {
        $query = 'SELECT CONCAT(id, ",", user_id, ",", amount, ",", hash) AS history FROM transaction';
        $result = $this->doctrine->getConnection()->fetchAll($query);
        return self::formatHistory($result);
    }

    /**
     * @param $hash
     * @return mixed
     *
     * Returns the history before the given hash
     *
     * Returned data is in the form of id1,user_id1,amount1|id2...
     */
    private function getPreviousTransactionHistory(string $hash)
    {
        $query = 'SELECT CONCAT(id, ",", user_id, ",", amount, ",", hash) AS history FROM transaction WHERE id < (SELECT id FROM transaction WHERE hash = ?)';
        $result = $this->doctrine->getConnection()->fetchAll($query, [$hash]);
        return self::formatHistory($result);
    }

    /**
     * @param $hash
     * @return bool
     *
     * Check the existence of a hash
     */
    private function checkHash(string $hash)
    {
        $query = 'SELECT COUNT(id) AS count FROM transaction WHERE hash = ?';
        $result = $this->doctrine->getConnection()->fetchAssoc($query, [$hash]);

        return $result['count'] > 0;
    }

    private static function formatHistory($rawHistory)
    {
        if (count($rawHistory) > 0) {
            $history = implode('|', array_column($rawHistory, 'history'));
        } else {
            $history = '';
        }

        return $history;
    }
}