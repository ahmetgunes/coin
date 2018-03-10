<?php
/**
 * Created by PhpStorm.
 * User: ahmet
 * Date: 3/9/18
 * Time: 8:18 PM
 */

namespace App\Models;


class AccountException extends CustomException
{
    public $message = 'An account problem has occurred.';
}