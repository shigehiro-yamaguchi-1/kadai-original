<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\M_item;

class ItemUserController extends Controller
{
    
    public function show($id)
    {
      $item = M_item::find($id);
      
      $data = [
          'item' => $item,
      ];
      
      $data += $this->counts($item);
      
      return view('items.show', $data);
    }
    

    // #################
    // # 高評価
    // #################
    public function high_rate()
    {
        $itemId = request()->itemId;
        
        \Auth::user()->high_rate($itemId);
        
        return redirect()->back();
    }

    public function dont_high_rate()
    {
        $itemId = request()->itemId;
        
        \Auth::user()->dont_high_rate($itemId);
        
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

    public function dont_low_rate()
    {
        $itemId = request()->itemId;
        
        \Auth::user()->dont_low_rate($itemId);
        
        return redirect()->back();
    }

}
