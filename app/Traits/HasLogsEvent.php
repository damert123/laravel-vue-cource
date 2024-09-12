<?php

namespace App\Traits;

use App\Events\LogComplitedEvent;
use App\Events\LogStartedEvent;
use App\Models\Log;
use Illuminate\Database\Eloquent\Model;

trait HasLogsEvent
{
    public static function bootHasLogsEvent()
    {
        static::created(function (Model $model) {
            event(new LogStartedEvent($model, 'created'));
           self::logEvent('created', null, $model->toArray(), $model);
           event(new LogComplitedEvent($model, 'created'));
        });

        static::updated(function (Model $model) {
            event(new LogStartedEvent($model, 'updated'));
            self::logEvent('updated', $model->getOriginal(), $model->getDirty(), $model);
            event(new LogComplitedEvent($model, 'updated'));

        });

        static::deleted(function (Model $model) {
            event(new LogStartedEvent($model, 'deleted'));
            self::logEvent('deleted', $model->toArray(), null, $model);
            event(new LogComplitedEvent($model, 'deleted'));

        });

        static::retrieved(function (Model $model) {
            event(new LogStartedEvent($model, 'retrieved'));
            self::logEvent('retrieved', null, $model->toArray(), $model);
            event(new LogComplitedEvent($model, 'retrieved'));

        });
    }




    protected static function logEvent($event, $oldValues, $newValues, Model $model = null){

        Log::create([
            'event' => $event,
            'model_id' => $model->id,
            'model_type' => get_class($model),
            'old_values' => json_encode($oldValues, JSON_UNESCAPED_UNICODE),
            'new_values' => json_encode($newValues, JSON_UNESCAPED_UNICODE),
        ]);

    }



}
