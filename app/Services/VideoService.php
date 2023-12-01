<?php

namespace App\Services;

use App\Models\LikedVideo;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoService
{
    public static function index()
    {
        $videos = Video::latest()->get();

        $likedVideos = LikedVideo::where('user_id', auth()->id())->get('video_id')
            ->pluck('video_id')->toArray();

        foreach ($videos as $video) {
            if (in_array($video->id,$likedVideos )) {
                $video->is_liked = true;
            }

        }

        return $videos;
    }

    public static function store(array $data) : Video
    {
        $path = Storage::disk('public')->put('video' , $data['file']);
        $fullPath = Storage::disk('public')->url($path);
        $data['file'] = $fullPath;
        return Video::create($data);
    }



    public static function show(Video $video)
    {
        $likedVideos = LikedVideo::where('user_id', auth()->id())->get('video_id')
            ->pluck('video_id')->toArray();

        if (in_array($video->id,$likedVideos )) {
            $video->is_liked = true;
        }

        return $video;
    }



    public static function update(Video $video, array $data)
    {


        return $video->update($data);
    }

    public static function destroy(Video $video)
    {
        return $video->delete();
    }

    public static function updateFile(Video $video, array $data)
    {
        // Проверяем, предоставлен ли новый файл изображения
        if (isset($data['file']) && $data['file'] instanceof \Illuminate\Http\UploadedFile) {
            // Удаляем старое изображение
            Storage::disk('public')->delete($video->file);

            // Сохраняем новое изображение
            $path = Storage::disk('public')->put('video', $data['file']);
            $fullPath = Storage::disk('public')->url($path);
            $data['file'] = $fullPath;
        }

        // Возвращаем обновленные данные
        return $data;
    }
}
