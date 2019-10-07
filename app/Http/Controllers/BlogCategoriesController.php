<?php

namespace App\Http\Controllers;

use App\BlogCategories;
use Illuminate\Http\Request;

class BlogCategoriesController extends Controller
{
    /**
     * Mapping blog_post with category.
     *
     * @return \Illuminate\Http\Response
     */
    public function mapCategoryWithBlog($blog_id, $category_id)
    {
        BlogCategories::create([
            'blog_id' => $blog_id,
            'category_id' => $category_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogCategories  $blogCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogCategories $blogCategories)
    {
        //
    }
}
