<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFriendController extends Controller
{
    public function store(Request $request, $id)
    {
        \Auth::user()->friend($id);
        return redirect()->back();
    }

    public function destroy($id)
    {
        \Auth::user()->unfriend($id);
        return redirect()->back();
    }
}
