<?php

namespace App\Http\Controllers\API;

use App\BlogPost;
use App\Http\Controllers\BlogCategoriesController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StoreFileController;
use App\Http\Requests\CreateBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use App\Http\Resources\BlogPostResource;
use App\Mail\BlogPublishedEmail;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use Illuminate\Support\Facades\Mail;

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

        $blogPosts = BlogPost::paginate($perPage);

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
        if($request->hasFile('image')) {
            $blogPost->image = $request->image->store('blog_post');
        }

        $blogPost->fill($request->all());
        $blogPost->save();

        return $blogPost;

        $blogPost->togglePublish();
        $blogPost->isPublished() ? $blogPost->unpublish() : $blogPost->publish();

        $file_name = isset($request['image']) ? (new StoreFileController())->storeFile($request->file('image'), 'blog_post') : $blogPost->image;

        $is_published = $blogPost->is_published;
        $blogPost->update(array_merge($request->except('_method'), ["image" => $file_name]));

        if($is_published == 0 && $request->is_published == 1)
        {
            $user_detail = auth()->user();
            $blog_detail = array_merge($request->except('_method'),
                [
                    "image" => $file_name,
                    "user_name" => $user_detail->name,
                    "email" => 'pinal@pinetco.com'//$user_detail->email,
                ]);
            $subject = 'BlogPost: Blog Published';
            $message = 'New blog published by ';

            Mail::to('pinal@pinetco.com')->send(new BlogPublishedEmail($blog_detail, $subject, $message));

        }

        return success(BlogPostResource::make($blogPost), 'BlogPost updated successfully');
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return success([], 'BlogPost deleted successfully!');

    }

    public function search()
    {
        \request()->validate([
            'query' => ['required'],
        ]);
        $searchResults = (new Search())
            ->registerModel(BlogPost::class, ['title','sub_title'])
            ->search(\request('query'));

        return BlogPostResource::make($searchResults);
    }
}
