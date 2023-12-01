<?php

namespace App\Http\Controllers\Main\Note;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Note\NoteResource;
use App\Models\Note;
use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Requests\Note\UpdateNoteRequest;
use App\Models\NoteComment;
use App\Services\NoteService;
use Mockery\Matcher\Not;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Note::class);
        $notes = NoteService::index();

        $notes = NoteResource::collection($notes)->resolve();

        $isAdmin = auth()->user()->is_admin;

        return inertia('Note/Index', compact('notes', 'isAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Note::class);
        return inertia('Note/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoteRequest $request)
    {
        $this->authorize('create', Note::class);
        $data = $request->validated();

        $note = NoteService::store($data);

        return redirect()->route('notes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        $this->authorize('view', $note);
        $note = NoteService::show($note);

        $note = NoteResource::make($note)->resolve();

        $isAdmin = auth()->user()->is_admin;


        return inertia('Note/Show', compact('note', 'isAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        $this->authorize('update', $note);
        $note = NoteResource::make($note)->resolve();
        return inertia('Note/Edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $this->authorize('update', $note);
        $data = $request->validated();
        NoteService::update($note, $data);

        return redirect()->route('notes.show', compact('note'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);
        NoteService::destroy($note);

        return redirect()->route('notes.index');

    }

    public function toggleLike(Note $note)
    {
        $res = auth()->user()->likedNotes()->toggle($note->id);

        $data['is_liked'] = count($res['attached']) > 0;
        $data['likes_count'] = $note->likedUsers()->count();
        return $data;
    }

    public function comment(Note $note, CommentRequest $request)
    {
        $data = $request->validated();
        $data['note_id'] = $note->id;
        $data['user_id'] = auth()->id();

        $comment = NoteComment::create($data);

        return new CommentResource($comment);
    }

    public function commentList(Note $note)
    {
        $comments = $note->comments()->latest()->get();

        return CommentResource::collection($comments);
    }

}
