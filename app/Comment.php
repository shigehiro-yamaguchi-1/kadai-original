<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'comment'];
    
    public function m_item()
    {
        return $this->belongsTo(M_item::Class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
