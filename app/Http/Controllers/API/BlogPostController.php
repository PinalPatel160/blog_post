<?php

namespace App\Http\Controllers\API;

use App\BlogPost;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use App\Http\Resources\BlogPostResource;
use Spatie\Searchable\Search;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {

        $perPage = min(request('per_page', 2), 100);

        $blogPosts = BlogPost::where('user_id', auth()->id())->paginate($perPage);

        return BlogPostResource::collection($blogPosts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBlogPostRequest $request)
    {

        $blogPost = new BlogPost($request->all());

        $blogPost->image = $request->image->store('image');
        $blogPost->user_id = auth()->id();

        $blogPost->save();

        $blogPost->syncCategories($request->categories_id);

        return success($blogPost, 'BlogPost created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \App\Http\Resources\BlogPostResource
     */
    public function show(BlogPost $post)
    {
        return BlogPostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogPostRequest $request, BlogPost $post)
    {
        if ($request->hasFile('image')) {
            $post->image = $request->image->store('blog_post');
        }

        $post->fill($request->all());
        $post->save();

        if ($request->filled('categories_id')) {
            $post->syncCategories($request->categories_id);
        }

        return success(BlogPostResource::make($post), 'BlogPost updated successfully');
    }

    public function destroy(BlogPost $post)
    {
        $post->delete();

        return success(true, 'BlogPost deleted successfully!');

    }

    public function search()
    {
        $searchResults = (new Search())
            ->registerModel(BlogPost::class, ['title', 'sub_title'])
            ->search(\request('query', ''));

        return BlogPostResource::make($searchResults);
    }
}
