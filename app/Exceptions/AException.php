<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class AException extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        parent::report();
        Log::channel('posts')->info("AException: произошла операция {$this->operation}");
    }
}
