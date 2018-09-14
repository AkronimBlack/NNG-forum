<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Favorite
 * @package App
 */
class Favorite extends Model
{
    use RecordsActivity;

//    protected $with = ['reply'];

//    protected $appends = ['favoritesCount'];

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reply ()
    {
        return $this->belongsTo(Reply::class , 'favorited_id');
    }


}
