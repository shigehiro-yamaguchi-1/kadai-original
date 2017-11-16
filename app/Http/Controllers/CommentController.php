<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\M_item;
class CommentController extends Controller
{
    public function newComment(M_item $item) {

        $comment = [
            'user_id' => request()->comment_user_id,
            'comment' => request()->comment,
        ];
        $rules = [
            'comment' => 'required|max:50',
        ];

        $valid = \Validator::make($comment, $rules);
        if ($valid->passes()) {
            $comment = new Comment($comment);

            $item->comments()->save($comment);

            return \Redirect::to(\URL::previous().'#reply')->with('success', 'コメントが送信されました。現在は承認待ちです。');
        } else {
            return \Redirect::to(\URL::previous().'#reply')->withErrors($valid)->withInput();
        }

    }
}
