<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    /**
     * @return Application|ResponseFactory|Response
     */
    public function logout() {
        Auth::logout();
        return response([], 200);
    }
}
