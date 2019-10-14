<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','is_active'];

    public function blog_posts()
    {
        return $this->belongsToMany(BlogPost::class);
    }
}
