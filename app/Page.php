<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * Get page by slug
     */
    public function getRouteKeyName()
    {   
        return 'slug';
    }

    /**
     * Page author
     */
    public function author() {
        return $this->belongsTo('App\User', 'author_id');
    }

    /**
     * Get message meta
     */
    public function metas() {
        return $this->hasMany('App\Postmeta', 'post_id');
    }

    // Getting post meta by meta key
    public function get_meta(string $meta_key) {
        $meta_value =  $this->metas()->where(['meta_key' => $meta_key, 'post_type' => 'pages'])->value('meta_value');
        $unserialized_meta_value = @unserialize($meta_value);
        if ($unserialized_meta_value !== false) {
            return $unserialized_meta_value;
        } else {
            return $meta_value;
        }
    }

    /**
     * Handling Slugs
     */
    public function setSlugAttribute($value) {

        if (static::whereSlug($slug = str_slug($value))->exists()) {
    
            $slug = $this->incrementSlug($slug);
        }
    
        $this->attributes['slug'] = $slug;
    }

    public function incrementSlug($slug) {

        $original = $slug;
    
        $count = 2;
    
        while (static::whereSlug($slug)->exists()) {
    
            $slug = "{$original}-" . $count++;
        }
    
        return $slug;
    
    }
}
