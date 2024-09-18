<?php

namespace App\Traits;


use App\LogFormatter\CrudLogFormatter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

trait HasLogsEventToFile
{
    public static function bootHasLogsEventToFile()
    {
        static::created(function (Model $model) {
            self::logToDynamicFile('created', $model);

        });

        static::updated(function (Model $model) {
            self::logToDynamicFile('updated', $model);
        });

        static::deleted(function (Model $model) {
            self::logToDynamicFile('deleted', $model);

        });

        static::retrieved(function (Model $model) {
            self::logToDynamicFile('retrieved', $model);
        });
    }



    public static function logToDynamicFile($event, Model $model)
    {
        $logFilePath = storage_path("logs/{$model->getTable()}/{$event}.log");

        config()->set('logging.channels.crud', [
            'driver' => 'single',
            'path' => $logFilePath,
            'tap' => [CrudLogFormatter::class],
            'replace_placeholders' => true,
        ]);

        Log::channel('crud')->info("$event event for model " . get_class($model) . " with ID: {$model->id}");
    }
}






//public static function logToFile($event, Model $model)
//{
//    self::logToDynamicFile($event, $model);
//
//}
