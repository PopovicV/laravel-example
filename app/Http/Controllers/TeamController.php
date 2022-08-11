<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeamController extends Controller
{
    /**
     * Returns all teams
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $teams = Team::all();

            return response()->json(["teams" => $teams]);
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            return response()->json(["message" => "Error occurred. Could not get teams."], 500);
        }
    }

    /**
     * Creates team
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $params = $request->all();
            $team = new Team();
            $team->name = $params['name'];
            $team->description = $params['description'];

            DB::beginTransaction();
            $team->save();
            DB::commit();

            return response()->json(['message' => 'Team successfully created']);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            return response()->json(["message" => "Error occurred. Could not create team."], 500);
        }

    }

    /**
     * Returns team by ID
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $team = Team::findOrFail($id);
            return response()->json(["team" => $team]);
        } catch (ModelNotFoundException $exception) {
            Log::debug($exception->getMessage());
            return response()->json(["message" => "Team not found."], 404);
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            return response()->json(["message" => "Error occurred. Could not get team."], 500);
        }
    }

    /**
     * Updates team
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $params = $request->all();
            $team = Team::findOrFail($id);
            $team->name = $params['name'];
            $team->description = $params['description'];

            DB::beginTransaction();
            $team->save();
            DB::commit();

            return response()->json(['message' => 'Team successfully updated']);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            return response()->json(["message" => "Team not found."], 404);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            return response()->json(["message" => "Error occurred. Could not update team."], 500);
        }
    }

    /**
     * Deletes team
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $team = Team::findOrFail($id);

            if ($team->users()->exists()) {
                return response()->json(['message' => 'Team has users. Please first remove all users from team.'], 403);
            }

            DB::beginTransaction();
            $team->delete();
            DB::commit();

            return response()->json(['message' => 'Team successfully deleted']);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            return response()->json(["message" => "Team not found."], 404);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            return response()->json(["message" => "Error occurred. Could not delete team."], 500);
        }
    }
}
