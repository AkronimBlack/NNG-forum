<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $guarded = [];

    protected $with = ['subject'];

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
    public static function feed($user, $take = 20)
    {
        return static::where('user_id', $user->id)
                     ->latest()
                     ->with('subject')
                     ->take($take)
                     ->get()
                     ->loadMorph('subject', [
                         Favorite::class => 'reply',
                         Reply::class => 'thread',
                         Thread::class => 'channel',
                     ])
//                     ->tap(function ($activity) {
//                         $activity->where('parentable_type', Favorite::class)
//                                  ->loadMorph('favorited.subject', [
//                                      Reply::class => 'thread',
//                                      Thread::class => 'channel',
//                                  ]);
//                     })
                     ->groupBy(function ($activity) {
                         return $activity->created_at->format('Y-m-d');
                     });
    }
}
