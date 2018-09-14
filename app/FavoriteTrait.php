<?php

namespace App;




trait FavoriteTrait
{
//    protected $with = ['favorites'];

	public function favorites()
    {
    	return $this->morphMany(Favorite::class , 'favorited');
    }

    public function favorite()
    {
        if(! $this->isFavorited())
        {
            $this->favorites()->create(['user_id'=>auth()->id()]);
            return back();
        }
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id' , auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();

    }

}