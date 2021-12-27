<?php

namespace App\Traits;

use App\Models\Team;
use App\Models\TeamUsers;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

trait HasTeams
{
    /**
     * Determine if the given team is the current team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function isCurrentTeam($team)
    {
        return $team->id === $this->currentTeam->id;
    }

    /**
     * Get the current team of the user's context.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentTeam()
    {
        if (is_null($this->current_team_id) && $this->id) {
            $this->switchTeam($this->defaultTeam());
        }

        return $this->belongsTo(Team::class, 'current_team_id');
    }

    /**
     * Switch the user's context to the given team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function switchTeam($team)
    {
        if (! $this->belongsToTeam($team)) {
            return false;
        }

        $this->forceFill([
            'current_team_id' => $team->id,
        ])->save();

        $this->setRelation('currentTeam', $team);

        return true;
    }

    /**
     * Get all of the teams the user owns or belongs to.
     *
     * @return \Illuminate\Support\Collection
     */
    public function allTeams()
    {
        return $this->ownedTeams->merge($this->teams)->sortBy('name');
    }

    /**
     * Get all of the teams the user owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ownedTeams()
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Get all of the teams the user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, TeamUsers::class);
    }

    /**
     * Get the user's "personal" team.
     *
     * @return \App\Models\Team
     */
    public function defaultTeam()
    {
        return $this->ownedTeams->first();
    }

    /**
     * Determine if the user owns the given team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function ownsTeam($team)
    {
        if (is_null($team)) {
            return false;
        }

        return $this->id == $team->{$this->getForeignKey()};
    }

    /**
     * Determine if the user belongs to the given team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function belongsToTeam($team)
    {
        return $this->teams->contains(function ($t) use ($team) {
                return $t->id === $team->id;
            }) || $this->ownsTeam($team);
    }
}
