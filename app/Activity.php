<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * @param $user
     * @return mixed
     */
    public static function feed($user)
    {
        return $user->activity()->latest()
        ->with('subject')->get()
        ->groupBy(function ($activity) {
            return $activity->created_at->format('Y-m-d');
        });
    }
}
