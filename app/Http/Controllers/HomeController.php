<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\M_item;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $m_items = M_item::all();
        return view('home', [
            'items' => $m_items,
        ]);
    }
}
