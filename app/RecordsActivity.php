<?php

namespace App;


trait RecordsActivity
{

    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getRecordActivity() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
//        static::deleting(function ($model) {
//            $model->activity()->delete();
//        });
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    protected static function getRecordActivity()
    {
        return ['created'];
    }

    public function recordActivity($event)
    {
        $this->activity()->create([
            'type'    => $event . '_' . strtolower(class_basename($this)),
            'user_id' => auth()->id(),
        ]);
    }


}
