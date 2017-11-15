<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // formのselect用
        $years = \Config::get('anime_item.years');
        $seasons = \Config::get('anime_item.seasons');;
        
        $data = [
            'years' => $years,
            'seasons' => $seasons,
        ];
        
        return view('admin.home', $data);
    }

    public function postIndex()
    {
        $test = \Artisan::call("createranking");
        var_dump($test);
        
        return redirect()->back();
    }

}
