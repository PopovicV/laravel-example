<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class TeamUserController extends Controller
{
    /**
     * Returns team with its users
     *
     * @param $teamId
     * @return JsonResponse
     */
    public function index($teamId): JsonResponse
    {
        $team = Team::findOrFail($teamId);
        return response()->json(["teamUsers" => $team->users]);
    }

    /**
     * Adds user to team
     *
     * @param $teamId
     * @param $userId
     * @return JsonResponse
     */
    public function store($teamId, $userId): JsonResponse
    {
        $user = User::findOrFail($userId);

        if ($user->team()->exists()) {
            return response()->json(["message" => "User already has team"], 403);
        }

        $team = Team::findOrFail($teamId);
        $user->team()->associate($team);
        $user->save();

        return response()->json(["message" => "User successfully added to a team", "teamUsers" => $team->users]);
    }

    /**
     * Removes user from team
     *
     * @param $teamId
     * @param $userId
     * @return JsonResponse
     */
    public function destroy($teamId, $userId): JsonResponse
    {
        $user = User::findOrFail($userId);

        if (!$user->team()->exists() || $user->team->id != $teamId) {
            return response()->json(["message" => "User is not part of any team or is part of another team"], 403);
        }

        $team = Team::findOrFail($teamId);
        $user->team()->dissociate();
        $user->save();

        return response()->json(["message" => "User removed from team", "teamUsers" => $team->users]);
    }
}
