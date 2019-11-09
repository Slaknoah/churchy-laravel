<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    /**
     * Get the user(author) that owns the message
     */
    public function author() {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }

    /**
     * Get the user(speaker) that owns the message
     */
    public function speaker() {
        return $this->belongsTo('App\User', 'speaker_id', 'id');
    }

    /**
     * Get the serie that owns the message
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

    /**
     * Get message meta
     */
    public function metas() {
        return $this->hasMany('App\Postmeta', 'post_id');
    }
}
