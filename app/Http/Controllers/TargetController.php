<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTargetRequest;
use App\Http\Requests\UpdateTargetRequest;
use App\Http\Resources\TargetCollection;
use App\Http\Resources\TargetResource;
use App\Models\Project;
use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return TargetCollection
     */
    public function index(Request $request)
    {
        return new TargetCollection($request->user()->currentTeam->projects()->paginate()->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTargetRequest $request
     * @return TargetResource
     */
    public function store(StoreTargetRequest $request)
    {
        $project = Project::query()->where('id', $request->post('project_id'))->firstOrFail();

        foreach(preg_split("/((\r?\n)|(\r\n?))/", $request->post('name')) as $line)
        {
            if(filter_var($line, FILTER_VALIDATE_DOMAIN))
            {
                if (!$project->targets()->where('domain', $line)->count())
                {
                    Target::create([
                        'domain' => $line,
                        'status' => 'pending',
                        'project_id' => $project->id
                    ]);
                }
            }
        }

        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param Target $team
     * @return TargetResource
     */
    public function show(Request $request, Target $target)
    {
        if (!$request->user()->belongsToTeam($target->project->team)) {
            abort(401);
        }

        return new TargetResource($target->load(['notes' => function($query) {
            $query->orderBy('id', 'DESC');
        }]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTargetRequest $request
     * @param Target $team
     * @return TargetResource
     */
    public function update(UpdateTargetRequest $request, Target $target)
    {
        if (!$request->user()->belongsToTeam($target->project->team)) {
            abort(401);
        }

        $validated = collect($request->validated());

        $target->update($validated->toArray());

        return new TargetResource($target);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Target $team
     * @return bool
     */
    public function destroy(Request $request, Target $target)
    {
        if (!$request->user()->belongsToTeam($target->team)) {
            abort(401);
        }

        return $target->delete();
    }
}
