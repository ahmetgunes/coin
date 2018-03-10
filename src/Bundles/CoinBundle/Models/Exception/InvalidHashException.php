<?php
/**
 * Created by PhpStorm.
 * User: ahmet
 * Date: 3/9/18
 * Time: 6:44 PM
 */

namespace App\Bundles\CoinBundle\Models\Exception;


use App\Models\CustomException;

class InvalidHashException extends CustomException
{
    public $message = 'Invalid hash has been sent.';
}