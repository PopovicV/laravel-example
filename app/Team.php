<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name', 'description'
    ];

    /**
     * Get the users for the team.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
