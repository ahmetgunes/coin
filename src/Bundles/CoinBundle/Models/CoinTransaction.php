<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 3.03.2018
 * Time: 19:40
 */

namespace App\Bundles\CoinBundle\Models;


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
        $miner = new Miner($this->doctrine->getConnection());

        list($hash, $amount) = $miner->mine();

        $transaction = new Transaction();
        $transaction->setUser($user);
        $transaction->setAmount($amount);
        $transaction->setHash($hash);

        $this->doctrine->getManager()->persist($transaction);
        $this->doctrine->getManager()->flush();

        return $hash;
    }

}