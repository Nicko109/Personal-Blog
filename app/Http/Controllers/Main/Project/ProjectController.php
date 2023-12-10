<?php

namespace App\Http\Controllers\Main\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\ProjectComment;
use App\Services\ProjectService;
use Mockery\Matcher\Not;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Project::class);
        $projects = ProjectService::index();

        $projects = ProjectResource::collection($projects)->resolve();

        $isAdmin = auth()->user()->is_admin;

        return inertia('Project/Index', compact('projects', 'isAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Project::class);
        return inertia('Project/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $this->authorize('create', Project::class);
        $data = $request->validated();

        $project = ProjectService::store($data);

        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $project = ProjectResource::make($project)->resolve();

        $isAdmin = auth()->user()->is_admin;


        return inertia('Project/Show', compact('project', 'isAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        $project = ProjectResource::make($project)->resolve();
        return inertia('Project/Edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $data = $request->validated();
        ProjectService::update($project, $data);

        return redirect()->route('projects.show', compact('project'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        ProjectService::destroy($project);

        return redirect()->route('projects.index');

    }


}
