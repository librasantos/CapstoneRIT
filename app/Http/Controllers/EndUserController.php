<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Group;

class EndUserController extends Controller
{
    //
    public function index()
    {
      $contacts = [];
      $user = User::with('groups')->first();

      $groups = $user->groups;
      foreach($groups as $group){
        $contacts = array_merge($contacts, $group->users->all());
      }

      return view('end_user', [
        'user' => $user,
        'contacts' => $contacts
      ]);
    }

    public function contactDetail($id)
    {
      return "Will display details of the user with id=$id";
    }

}
