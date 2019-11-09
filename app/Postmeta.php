<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postmeta extends Model
{
    /**
     * Metas message
     */
    public function message() {
        return $this->belongsTo('App\Message', 'post_id');
    }

    /**
     * Metas page
     */
    public function page() {
        return $this->belongsTo('App\Page', 'post_id');
    }
    
    /**
     * Metas User
     */
    public function user() {
        return $this->belongsTo('App\User', 'post_id');
    }

    /**
     * Metas User
     */
    public function serie() {
        return $this->belongsTo('App\Serie', 'post_id');
    }
}
