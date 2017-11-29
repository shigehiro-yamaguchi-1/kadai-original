<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\M_item;
use App\Events\MessagePosted;


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
    
    public function getComment($id) {
        
        $item = M_item::find($id);
        // $comment = $item->comments()->with('user')->get();
        
        // $data = [
        //     'comment' => $comment,
        // ];
        // return $data;

        return $item->comments()->with('user')->orderby('created_at', 'DESC')->get();
    }

    public function postComment($id) {

        $user = \Auth::user();
        $message = request()->get('comment');
        // $message = request()->comment;

        $item = M_item::find($id);
        $comment = [
            'user_id' => $user->id,
            'comment' => $message,
        ];
        $rules = [
            'comment' => 'required|max:50',
        ];
        $valid = \Validator::make($comment, $rules);

        if ($valid->passes()) {
            $comment = new Comment($comment);

            // $item->comments()->save($comment);

            $message = $item->comments()->create([
                'user_id' => $user->id,
                'comment' => $message,
            ]);

            broadcast(new MessagePosted($message, $user))->toOthers();
            return ['status' => 'OK'];

        } else {
            return ['status' => 'NG'];
        }

    }

}
