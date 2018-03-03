<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 3.03.2018
 * Time: 17:10
 */

namespace App\Services;


use Doctrine\DBAL\Connection;

class KeyGenerator
{
    /**
     * @var Connection
     */
    protected $conn;

    /**
     * KeyGenerator constructor.
     * @param Connection $conn
     */
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    /**
     * @return array
     */
    public function generateKeyPairForUser()
    {
        $query = 'SELECT COUNT(id) AS count FROM user WHERE private_key = ? LIMIT 1';

        $privateKey = self::generateNewKey();

        while (true) {
            $result = $this->conn->fetchAssoc($query, [$privateKey]);
            if ($result['count'] == 0) {
                break;
            }
        }

        return [$privateKey, md5($privateKey)];
    }

    /**
     * @param int $length
     * @return int
     *
     * Generate an integer with given $length
     */
    protected static function generateNewKey(int $length = 10)
    {
        return rand(
            pow(10, $length - 1) + 1,
            pow(10, $length) - 1
        );
    }
}