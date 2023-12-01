<?php

namespace App\Http\Resources\Note;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->created_at->diffForHumans(),
            'is_liked' => $this->is_liked ?? false,
            'likes_count' => $this->likedUsers->count(),
            'comments_count' => $this->comments_count
        ];
    }
}
