<?php

namespace App\Exceptions;

class MissingArrayKeyException extends \Exception
{
    protected $message = 'Array Key is missing';
}
