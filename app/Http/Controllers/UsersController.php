<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function profile($id)
    {
        $userData = User::find($id);
        // 他人も見るので最小限
        $user = User::select('id', 'name')->where('id', '=', $id)->get()->toArray();
        
        // 視聴一覧（＝評価したもの）
        $evaluates = $userData->evaluates()->orderby('type')->get();

        $data = [
            'user' => $user,
            'evaluates' => $evaluates,
        ];
        
        $data += $this->user_counts($userData);
        
        return view('users.profile', $data);
    }
    
    public function friend_list($id)
    {
        $userData = User::find($id);
        // 他人も見るので最小限
        $user = User::select('id', 'name')->where('id', '=', $id)->get()->toArray();

        $friendData = $userData->friends()->select('users.id', 'users.name')->get();

        $data = [
            'user' => $user,
            'friends' => $friendData,
        ];

        $data += $this->user_counts($userData);

        return view('users.friend_list', $data);
    }
}