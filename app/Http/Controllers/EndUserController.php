<?php

namespace App\Http\Controllers;

use App\Repositories\ChatRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EndUserController extends Controller
{
    //
    public function index()
    {
      $user = Auth::user();
      $contacts = ChatRepository::getContactsWithUnreadTotalMessages($user->id);

      return view('end_user', [
        'user' => $user,
        'contacts' => $contacts,
      ]);
    }

    public function contactDetail($id)
    {
      return "Will display details of the user with id=$id";
    }

    public function getContacts()
    {
        $userId = Auth::guard('api')->user()->id;
        return ChatRepository::getContactsWithUnreadTotalMessages($userId);
    }

}
