<?php
/**
 * Created by PhpStorm.
 * User: ahmet
 * Date: 3/9/18
 * Time: 6:54 PM
 */

namespace App\Models;


class CustomException extends \Exception
{
    const DEFAULT_MESSAGE = 'An exception has occurred while processing your request please try again later.';
    public $message = self::DEFAULT_MESSAGE;
}