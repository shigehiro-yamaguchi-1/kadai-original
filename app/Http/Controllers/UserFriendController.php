<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFriendController extends Controller
{
    public function friend(Request $request, $id)
    {
        \Auth::user()->friend($id);
        return redirect()->back();
    }

    public function unfriend($id)
    {
        \Auth::user()->unfriend($id);
        return redirect()->back();
    }
}
