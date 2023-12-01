<?php

namespace App\Http\Controllers\Main\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CommentRequest;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Comment;
use App\Models\LikedPost;
use App\Models\Note;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Post::class);
        $posts = PostService::index();
        $isAdmin = auth()->user()->is_admin;
        $posts = PostResource::collection($posts)->resolve();

        return inertia('Post/Index', compact('posts', 'isAdmin'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        return inertia('Post/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $this->authorize('create', Post::class);
        $data = $request->validated();

        $post = PostService::store($data);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        $post = PostService::show($post);
        $isAdmin = auth()->user()->is_admin;
        $post = PostResource::make($post)->resolve();

        return inertia('Post/Show', compact('post', 'isAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $post = PostResource::make($post)->resolve();

        return inertia('Post/Edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->validated();


        $data = PostService::updateImage($post, $data);
        PostService::update($post, $data);

        return redirect()->route('posts.show', compact('post'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        PostService::destroy($post);

        return redirect()->route('posts.index');

    }

    public function toggleLike(Post $post)
    {
        $res = auth()->user()->likedPosts()->toggle($post->id);

        $data['is_liked'] = count($res['attached']) > 0;
        $data['likes_count'] = $post->likedUsers()->count();
        return $data;
    }

    public function comment(Post $post, CommentRequest $request)
    {
        $data = $request->validated();
        $data['post_id'] = $post->id;
        $data['user_id'] = auth()->id();

        $comment = Comment::create($data);

        return new CommentResource($comment);

    }

    public function commentList(Post $post)
    {
        $comments = $post->comments()->latest()->get();

        return CommentResource::collection($comments);
    }

}
