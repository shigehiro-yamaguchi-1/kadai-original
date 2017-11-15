<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;
use App\SocialProvider;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function items()
    {
        return $this->belongsToMany(M_item::class, 'item_evaluate', 'user_id', 'item_id')->withPivot('type')->withTimestamps();
    }
    
    
    // #################
    // # 高評価
    // #################
    public function high_rate_items()
    {
        return $this->items()->where('type', \Config::get('anime_type.high_rate'));
    }
    
    public function high_rate($itemId)
    {
        // 既にhigh_rateしているかの確認
        $exist = $this->is_high_rating($itemId);
        
        if ($exist) {
            // 既にhigh_rateしていれば何もしない
            return false;
        } else {
            // 未high_rateであればhigh_rateする
            $this->items()->attach($itemId, ['type' => \Config::get('anime_type.high_rate')]);
            
            // 既にbad_rateであればdetachする
            $this->dont_low_rate($itemId);

            return true;
        }
    }
    
    public function dont_high_rate($itemId)
    {
        // 既にhigh_rateしているかの確認
        $exist = $this->is_high_rating($itemId);
        
        if ($exist) {
            // 既にhigh_rateしていればhigh_rateを外す
            \DB::delete("DELETE FROM item_evaluate WHERE user_id = ? AND item_id = ? AND type = ?", [\Auth::user()->id, $itemId, \Config::get('anime_type.high_rate')]);
            return true;
        } else {
            // 未high_rateであれば何もしない
            return false;
        }
    }
    
    public function is_high_rating($itemId)
    {
        return $this->high_rate_items()->where('item_id', $itemId)->exists();
    }

    // #################
    // # 低評価
    // #################
    public function low_rate_items()
    {
        return $this->items()->where('type', \Config::get('anime_type.low_rate'));
    }
    
    public function low_rate($itemId)
    {
        // 既にlow_rateしているかの確認
        $exist = $this->is_low_rating($itemId);
        
        if ($exist) {
            // 既にlow_rateしていれば何もしない
            return false;
        } else {
            // 未low_rateであればlow_rateする
            $this->items()->attach($itemId, ['type' => \Config::get('anime_type.low_rate')]);

            // 既にhigh_rateであればdetachする
            $this->dont_high_rate($itemId);

            return true;
        }
    }
    
    public function dont_low_rate($itemId)
    {
        // 既にlow_rateしているかの確認
        $exist = $this->is_low_rating($itemId);
        
        if ($exist) {
            // 既にlow_rateしていればlow_rateを外す
            \DB::delete("DELETE FROM item_evaluate WHERE user_id = ? AND item_id = ? AND type = ?", [\Auth::user()->id, $itemId, \Config::get('anime_type.low_rate')]);
            return true;
        } else {
            // 未low_rateであれば何もしない
            return false;
        }
    }
    
    public function is_low_rating($itemId)
    {
        return $this->low_rate_items()->where('item_id', $itemId)->exists();
    }

    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }
    
}