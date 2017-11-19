<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function show($id)
    {
        $userData = User::find($id);
        // 他人も見るので最小限
        $user = User::select('id', 'name')->where('id', '=', $id)->get()->toArray();

        $data = [
            'user' => $user,
        ];
        
        $data += $this->user_counts($userData);
        
        return view('users.profile', $data);
    }
}