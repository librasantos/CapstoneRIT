<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminController extends Controller
{
    public function index()
    {
      return view('admin');
    }

    public function getUsers()
    {
        return User::with(['groups'])->get();
//        return User::with(['groups' => function($query) {
//            $query->select('id', 'name');
//        }])->get();
    }

    public function getGroups()
    {
        return Group::select('id', 'name')->get();
    }

    public function getUserGroups($userId)
    {
        return User::with('groups')->find($userId)->groups();
    }

    public function attachUserToGroup($userId, $groupId)
    {
        return User::find($userId)->groups()->attach($groupId);
    }

    public function detachUserFromGroup($userId, $groupId)
    {
        return User::find($userId)->groups()->detach($groupId);
    }
}
