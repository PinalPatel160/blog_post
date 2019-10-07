<?php

namespace App\Http\Controllers\API;

use App\BlogPost;
use App\Http\Controllers\BlogCategoriesController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StoreFileController;
use App\Http\Requests\CreateBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use App\Http\Resources\BlogPostResource;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $blogPosts = BlogPost::paginate(2);

        return BlogPostResource::collection($blogPosts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBlogPostRequest $request)
    {
        $file = $request->file('image');

        $blogPost = BlogPost::create(array_merge($request->except('category_id'),
            ["image" => (new StoreFileController())->storeFile($file, 'blog_post')]
        ));
        //return $request['category_id'];
        (new BlogCategoriesController())->mapCategoryWithBlog($blogPost->id, $request['category_id']);

        return success($blogPost, 'BlogPost created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \App\Http\Resources\BlogPostResource
     */
    public function show(BlogPost $blogPost)
    {
        return BlogPostResource::make($blogPost);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogPostRequest $request, BlogPost $blogPost)
    {
        $file_name = isset($request['image']) ? (new StoreFileController())->storeFile($request->file('image'), 'blog_post') : $blogPost->image;

        $blogPost->update(array_merge($request->except('_method'), ["image" => $file_name]));

        return success(BlogPostResource::make($blogPost), 'BlogPost updated successfully');
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return success([], 'BlogPost deleted successfully!');

    }
}
