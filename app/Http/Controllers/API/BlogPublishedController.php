<?php

namespace App\Http\Controllers\API;

use App\BlogPost;
use App\Http\Controllers\Controller;
use App\Jobs\BlogPublishMail;

class BlogPublishedController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPost $blogPost)
    {
        $blogPost->publish();

        //Send the mail of all user
        $this->dispatch(new BlogPublishMail($blogPost));

        return success(true, 'Blog has been published successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPost $blogPost)
    {
        $blogPost->unpublish();

        return success(true, 'Blog has been unpublished.');
    }
}
