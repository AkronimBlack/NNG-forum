<?php

namespace App;




trait FavoriteTrait
{

    public static function bootFavoriteTrait()
    {
        static::deleting(function ($model){
           $model->favorites->each->delete();
        });
    }

	public function favorites()
    {
    	return $this->morphMany(Favorite::class , 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id'=>auth()->id()];

        if(! $this->isFavorited())
        {
            $this->favorites()->create($attributes);
            return back();
        }
    }

    public function unfavorite()
    {
        $attributes = ['user_id'=>auth()->id()];

        $this->favorites()->where($attributes)->get()->each->delete();

    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id' , auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();

    }

}