<?php

namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $data = [];

        $data['usersCount'] = User::all()->count();
        $data['postsCount'] = Post::all()->count();
        $data['projectsCount'] = Project::all()->count();

        return view('main.index',compact('data'));
    }
}
