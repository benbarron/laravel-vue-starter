<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @return Renderable
     */
    public function vue(Request $request)
    {
        return view('admin.layout', [
            'token' => $request->user()->api_token,
            'name' => config('app.name', 'Laravel')
        ]);
    }

    /**
    * Show the landing page
    *
    * @return Renderable
    */
    public function site()
    {
        return view('site.home');
    }
}
