<?php

namespace App\Http\Controllers\Main\Video;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Video\VideoResource;
use App\Models\Post;
use App\Models\Video;
use App\Http\Requests\Video\StoreVideoRequest;
use App\Http\Requests\Video\UpdateVideoRequest;
use App\Models\VideoComment;
use App\Services\PostService;
use App\Services\VideoService;
use Mockery\Matcher\Not;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $this->authorize('viewAny', Video::class);
        $videos = VideoService::index();
        $isAdmin = auth()->user()->is_admin;
        $videos = VideoResource::collection($videos)->resolve();

        return inertia('Video/Index', compact('videos', 'isAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Video::class);
        return inertia('Video/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoRequest $request)
    {
        $this->authorize('create', Video::class);
        $data = $request->validated();

        $video = VideoService::store($data);

        return redirect()->route('videos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        $this->authorize('view', $video);
        $video = VideoService::show($video);
        $isAdmin = auth()->user()->is_admin;
        $video = VideoResource::make($video)->resolve();

        return inertia('Video/Show', compact('video', 'isAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        $this->authorize('update', $video);
        $video = VideoResource::make($video)->resolve();
        return inertia('Video/Edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        $this->authorize('update', $video);
        $data = $request->validated();

        $data = VideoService::updateFile($video, $data);

        VideoService::update($video, $data);

        return redirect()->route('videos.show', compact('video'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $this->authorize('delete', $video);
        VideoService::destroy($video);

        return redirect()->route('videos.index');
    }

    public function toggleLike(Video $video)
    {
        $res = auth()->user()->likedVideos()->toggle($video->id);

        $data['is_liked'] = count($res['attached']) > 0;
        $data['likes_count'] = $video->likedUsers()->count();

        return $data;
    }

    public function comment(Video $video, CommentRequest $request)
    {
        $data = $request->validated();

        $data['video_id'] = $video->id;
        $data['user_id'] = auth()->id();

        $comment = VideoComment::create($data);

        return new CommentResource($comment);

    }

    public function commentList(Video $video)
    {
        $comments = $video->comments()->latest()->get();

        return CommentResource::collection($comments);
    }

}
