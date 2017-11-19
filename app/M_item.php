<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_item extends Model
{
    // protected $guarded = ['id'];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'item_evaluate', 'item_id', 'user_id')->withPivot('type')->withTimestamps();
    }

    // #################
    // # 高評価
    // #################
    public function high_rate_users()
    {
        return $this->users()->where('type', \Config::get('anime_type.high_rate'));
    }

    // #################
    // # 低評価
    // #################
    public function low_rate_users()
    {
        return $this->users()->where('type', \Config::get('anime_type.low_rate'));
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
}
