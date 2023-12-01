<?php

namespace App\Services;

use App\Models\LikedNote;
use App\Models\LikedPost;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteService
{
    public static function index()
    {
        $notes = Note::latest()->get();

        $likedNoteIds = LikedNote::where('user_id', auth()->id())->get('note_id')
            ->pluck('note_id')->toArray();

        foreach ($notes as $note) {
            if(in_array($note->id, $likedNoteIds)) {
                $note->is_liked = true;
            }
        }

        return $notes;
    }




    public static function store(array $data) : Note
    {
        return Note::create($data);
    }

    public static function show(Note $note)
    {
        $likedNoteIds = LikedNote::where('user_id', auth()->id())->get('note_id')
            ->pluck('note_id')->toArray();

        if(in_array($note->id, $likedNoteIds)) {
            $note->is_liked = true;
        }

        return $note;
    }



    public static function update(Note $note, array $data)
    {

        return $note->update($data);
    }

    public static function destroy(Note $note)
    {
        return $note->delete();
    }
}
