<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class BlogPost extends Model implements Searchable
{
    protected $guarded = [];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return url( $this->image);
    }

    public function getSearchResult(): SearchResult
    {
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            route('blogPost.show', $this->id)
        );
    }

    public function attachCategories($categories)
    {
        $this->categories()->attach($categories);
    }
}
