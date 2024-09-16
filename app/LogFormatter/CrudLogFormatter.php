<?php

namespace App\LogFormatter;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;

class CrudLogFormatter
{
    /**
     * Create a new class instance.
     */
    public function __invoke(Logger $logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new LineFormatter(
                '%message%' . PHP_EOL
            ));
        }
    }
}
