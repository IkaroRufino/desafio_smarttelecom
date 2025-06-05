<?php

namespace App\Models;

use Laravel\Jetstream\Membership as JetstreamMembership;

class Membership extends JetstreamMembership
{
    public $incrementing = true;

    protected $fillable = ['team_id', 'user_id', 'role'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
