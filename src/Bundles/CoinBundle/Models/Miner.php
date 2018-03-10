<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 3.03.2018
 * Time: 17:51
 */

namespace App\Bundles\CoinBundle\Models;


use App\Bundles\CoinBundle\Models\Exception\InvalidHashException;
use Doctrine\DBAL\Connection;

class Miner
{
    const VERIFICATION_PART = '000';

    /**
     * Always 1
     */
    const BLOCK_NUMBER = 1;

    const COUNT = 40;

    /**
     * @param string $history
     * @return array
     *
     * Mines a new hash and returns a hash, nonce pair
     */
    public function mine(string $history)
    {
        $hash = '';
        $nonce = 0;

        while (strpos($hash, self::VERIFICATION_PART) !== 0) {
            $hash = self::calculateHash($history, $nonce);
            $nonce++;
        }

        return [$hash, $nonce];
    }

    /**
     * @param string $hash
     * @param string $history
     * @return int
     *
     * Verifies and returns the amount corresponding to a given hash
     */
    public function verify(string $hash, string $history)
    {
        $nonce = 0;
        $key = '';

        while ($hash !== $key) {
            $key = self::calculateHash($history, $nonce);
            $nonce++;
        }

        return $nonce;
    }

    /**
     * @param $history
     * @param $nonce
     * @return string
     *
     * Calculates a hash using sha1
     */
    private static function calculateHash($history, $nonce)
    {
        return sha1(self::BLOCK_NUMBER . '_' . $history . $nonce);
    }
}