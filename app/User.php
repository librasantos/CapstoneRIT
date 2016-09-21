<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token', 
    ];


    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_groups');
    }

    public function incomingMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }


    public function outgoingMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
}
