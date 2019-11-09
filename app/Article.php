<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Article extends Model
{

    /**
     * Getting user (author) of article
     */
    public function author() {
        return $this->belongsTo('App\User', 'author_id');
    }

    /**
     * Get the serie that owns the article
     */
    public function series() {
        return $this->belongsTo('App\Serie', 'series_id', 'id');
    }   


    /**
     * Modify date formats
     */
    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y/m/d');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y/m/d');
    }
}
