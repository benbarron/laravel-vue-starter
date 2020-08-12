<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\MenuItem;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the vue application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function vue()
    {
        return view('admin.layout');
    }

    /**
    * Show the landing page
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function site()
    {
    return view('site.home');
    }
}
