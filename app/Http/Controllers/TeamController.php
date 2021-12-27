<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\TeamCollection;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * Switch current team
     *
     * @param Request $request
     * @param $id
     * @return JsonResource
     */
    public function switchTeam(Request $request, $id) {
        if ($request->user()->switchTeam(Team::query()->where('id', $id)->firstOrFail())) {
            return new JsonResource([
                'success' => true
            ]);
        }

        return new JsonResource([
            'success' => false
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return TeamCollection
     */
    public function index(Request $request)
    {
        return new TeamCollection($request->user()->teams()->paginate()->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTeamRequest $request
     * @return TeamResource
     */
    public function store(StoreTeamRequest $request)
    {
        $validated = collect($request->validated());

        $validated->put('user_id', $request->user()->id);

        if ($file = $request->file('file')) {
            $file->store('logo', ['disk' => 'public']);
            $validated->put('logo', $file->hashName());
        }

        $team = Team::create($validated->toArray());

        $team->users()->attach($request->user());

        $request->user()->switchTeam($team);

        return new TeamResource($team);
    }

    /**
     * Display the specified resource.
     *
     * @param Team $team
     * @return TeamResource
     */
    public function show(Request $request, Team $team)
    {
        if (!$request->user()->belongsToTeam($team)) {
            abort(401);
        }

        return new TeamResource($team);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTeamRequest $request
     * @param Team $team
     * @return TeamResource
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        if (!$request->user()->belongsToTeam($team)) {
            abort(401);
        }

        $validated = collect($request->validated());

        if ($file = $request->file('file')) {
            $file->store('logo', ['disk' => 'public']);
            $validated->put('logo', $file->hashName());
        }

        if ($request->post('delete_file') && $team->logo) {
            $validated->put('logo', null);
            Storage::disk('public')->delete('logo/'. $team->logo);
        }

        $team->update($validated->toArray());

        return new TeamResource($team);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Team $team
     * @return bool
     */
    public function destroy(Request $request, Team $team)
    {
        if (!$request->user()->belongsToTeam($team)) {
            abort(401);
        }

        return $team->delete();
    }
}
