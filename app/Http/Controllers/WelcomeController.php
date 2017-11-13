<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\M_item;

class WelcomeController extends Controller
{
    public function index()
    {
        $m_items = M_item::all();

        foreach( $m_items as $key => $item){
            $m_items[$key]->counts = $this->counts($item);
        }

        $data = [
            'items' => $m_items,
        ];

        return view('welcome', $data);
    }
}

