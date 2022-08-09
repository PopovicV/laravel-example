<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Team;

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

      factory(App\User::class, 50)->create()->each(function ($user) use ($teams){
        $user->team()->associate($teams->random());
        $user->save();
      });
    }
}
