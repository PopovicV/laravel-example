<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
  use HasFactory;
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
