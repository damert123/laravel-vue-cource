<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class BException extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        parent::report();
        Log::channel('posts')->info("BException: произошла операция {$this->operation}");
    }
}
