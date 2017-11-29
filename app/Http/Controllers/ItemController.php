<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\M_item;
use App\User;
use App\Comment;

class ItemController extends Controller
{
    public function show($id)
    {
        $item = M_item::find($id);

        $comments = $item->comments()->orderBy('created_at', 'DESC')->paginate(5);
        
        foreach ($comments as $comment) {
            $user = User::find($comment->user_id);
            $comments->user = $user;
        }

        $config_rate_names = $this->config_rate_names();

        $data = [
            'item' => $item,
            'comments' => $comments,
            'high_rate_name' => $config_rate_names['high_rate_name'],
            'low_rate_name' => $config_rate_names['low_rate_name'],
        ];

        $data += $this->item_counts($item);

        return view('items.item_detail', $data);
    }
    
}
