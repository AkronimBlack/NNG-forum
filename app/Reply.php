<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use FavoriteTrait;
    use RecordsActivity;

    protected $with = ['owner' , 'favorites'];

    protected $appends = ['favoritesCount' , 'isFavorited'];

    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function logDeleteActivity()
    {
        $this->recordActivity('deleted');
    }





}
