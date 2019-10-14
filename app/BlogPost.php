<?php

namespace App;

use App\Mail\BlogPublishedEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class BlogPost extends Model implements Searchable
{
    protected $fillable = ['user_id', 'description', 'image', 'title', 'sub_title', 'published_at'];

    protected $appends = ['image_path'];

    /**
     * Attach image full path
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getImagePathAttribute()
    {
        return url($this->image);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get search result by query
     *
     * @return \Spatie\Searchable\SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            route('post.show', $this->id)
        );
    }

    /**
     * Attach blog to category
     *
     * @param $categories
     */
    public function attachCategories($categories)
    {
        $this->categories()->attach([$categories]);
    }

    public function syncCategories($categories)
    {
        $this->categories()->sync($categories);
    }

    /**
     * Blog publish and notify all users
     *
     * @param $published_at
     */
    public function publish()
    {
        $this->update(['published_at' => now()]);

    }

    /**
     * Blog un-publish
     */
    public function unpublish()
    {
        $this->update(['published_at' => null]);
    }

}
