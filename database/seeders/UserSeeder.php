<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $teams = Team::all();      

      User::factory()->count(50)->create()->each(function ($user) use ($teams){
        $user->team()->associate($teams->random());
        $user->save();
      });
    }
}
