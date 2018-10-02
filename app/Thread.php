<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use FavoriteTrait;
    use RecordsActivity;
    protected $guarded = [];

    protected $with = ['channel', 'owner'];

    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

    }

    public function path()
    {
        return '/threads/' . $this->channel->slug . '/' . $this->id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)
                    ->where('trash', 0);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

//        event(new ThreadHasNewReply($this, $reply));
        $this->notifySubscribers($reply);
        return $reply;
    }

    public function notifySubscribers($reply)
    {
        $this->subscriptions
            ->where('user_id', '!=', $reply->user_id)
            ->each
            ->notify($reply);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }


    public function logDeleteActivity()
    {
        $this->recordActivity('deleted');
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([

            'user_id' => $userId ?: auth()->id(),
        ]);

        return $this;
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscriptions::class);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
             ->where('user_id', $userId ?: auth()->id())
             ->delete();
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
                    ->where('user_id', auth()->id())
                    ->exists();
    }
}
