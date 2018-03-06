<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 3.03.2018
 * Time: 17:51
 */

namespace App\Bundles\CoinBundle\Models;


use Doctrine\DBAL\Connection;

class Miner
{
    const VERIFICATION_PART = '000';

    /**
     * Always 1
     */
    const BLOCK_NUMBER = 1;

    /**
     * @var Connection
     */
    protected $conn;

    /**
     * Miner constructor.
     * @param Connection $conn
     */
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    /**
     * @return array
     *
     * Mines a new hash and returns hash, nonce pair
     */
    public function mine()
    {
        $transHistory = $this->getTransactionHistory();

        $hash = '';
        $nonce = 0;

        while (strpos($hash, self::VERIFICATION_PART) !== 0) {
            $hash = sha1(self::BLOCK_NUMBER . '_' . $transHistory . $nonce);
            $nonce++;
        }

        return [$hash, $nonce];
    }

    /**
     * @param $hash
     * @return int
     */
    public function verify($hash)
    {
        $transHistory = $this->getPreviousTranscationHistory($hash);
        $nonce = 0;
        $key = '';

        while ($hash !== $key) {
            $key = sha1(self::BLOCK_NUMBER . '_' . $transHistory . $nonce);
            $nonce++;
        }

        return $nonce;
    }

    private function getTransactionHistory()
    {
        $result = $this->conn->fetchAssoc('SELECT GROUP_CONCAT(CONCAT(id, ",", user_id, ",", amount, ",", hash) SEPARATOR "|") AS history FROM transaction');

        return $result['history'];
    }

    private function getPreviousTranscationHistory($hash)
    {
        $result = $this->conn->fetchAssoc('SELECT GROUP_CONCAT(CONCAT(id, ",", user_id, ",", amount, ",", hash) SEPARATOR "|") AS history FROM transaction WHERE id < (SELECT id FROM transaction WHERE hash = ?)', [$hash]);

        return $result['history'];
    }
}