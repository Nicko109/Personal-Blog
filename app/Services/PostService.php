<?php

namespace App\Services;

use App\Models\LikedPost;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public static function index()
    {
        $posts = Post::latest()->get();

        return $posts;
    }

    public static function store(array $data) : Post
    {
        $path = Storage::disk('public')->put('post' , $data['image']);
        $fullPath = Storage::disk('public')->url($path);
        $data['image'] = $fullPath;
        return Post::create($data);
    }





    public static function update(Post $post, array $data)
    {

        return $post->update($data);
    }

    public static function destroy(Post $post)
    {
        return $post->delete();
    }

    public static function updateImage(Post $post, array $data)
    {
        // Проверяем, предоставлен ли новый файл изображения
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            // Удаляем старое изображение
            Storage::disk('public')->delete($post->image);

            // Сохраняем новое изображение
            $path = Storage::disk('public')->put('post', $data['image']);
            $fullPath = Storage::disk('public')->url($path);
            $data['image'] = $fullPath;
        }

        // Возвращаем обновленные данные
        return $data;
    }

}
