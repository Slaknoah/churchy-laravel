<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    /** 
     * Get serie messages
     */
    public function messages() {
        return $this->hasMany('App\Message', 'series_id', 'id');
    }

    /**
     * Get serie articles
     */
    public function articles() {
        return $this->hasMany('App\Article', 'series_id');
    }

    /**
     * Get series meta
     */
    public function metas() {
        return $this->hasMany('App\Postmeta', 'post_id');
    }
}
