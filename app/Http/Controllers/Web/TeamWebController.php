<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Team;

class TeamWebController extends Controller
{
  public function index()
  {
    $teams = Team::all();
    return view("teams", [
      "teams" => $teams
    ]);
  }

  public function show($id)
  {
      $team = Team::find($id);
      return view("team", [
        "team" => $team
      ]);
  }
}
