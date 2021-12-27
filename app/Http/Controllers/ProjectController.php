<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectViewResource;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ProjectCollection
     */
    public function index(Request $request)
    {
        return new ProjectCollection($request->user()->currentTeam->projects()->paginate()->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     * @return ProjectResource
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = collect($request->validated());

        $validated->put('team_id', $request->user()->currentTeam->id);

        $team = Project::create($validated->toArray());

        return new ProjectResource($team);
    }

    /**
     * Display the specified resource.
     *
     * @param Project $team
     * @return ProjectViewResource
     */
    public function show(Request $request, Project $project)
    {
        if (!$request->user()->belongsToTeam($project->team)) {
            abort(401);
        }

        return new ProjectViewResource($project->load(['targets'=> function($query) {
            $query->orderBy('status', 'ASC');
        }]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param Project $team
     * @return ProjectResource
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        if (!$request->user()->belongsToTeam($project->team)) {
            abort(401);
        }

        $validated = collect($request->validated());

        $project->update($validated->toArray());

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $team
     * @return bool
     */
    public function destroy(Request $request, Project $project)
    {
        if (!$request->user()->belongsToTeam($project->team)) {
            abort(401);
        }

        return $project->delete();
    }
}
