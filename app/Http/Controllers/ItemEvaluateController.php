<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemEvaluateController extends Controller
{
    // #################
    // # 高評価
    // #################
    public function high_rate()
    {
        $itemId = request()->itemId;
        
        \Auth::user()->high_rate($itemId);
        
        return redirect()->back();
    }

    public function un_high_rate()
    {
        $itemId = request()->itemId;
        
        \Auth::user()->un_high_rate($itemId);
        
        return redirect()->back();
    }

    // #################
    // # 低評価
    // #################
    public function low_rate()
    {
        $itemId = request()->itemId;
        
        \Auth::user()->low_rate($itemId);
        
        return redirect()->back();
    }

    public function un_low_rate()
    {
        $itemId = request()->itemId;
        
        \Auth::user()->un_low_rate($itemId);
        
        return redirect()->back();
    }
}
