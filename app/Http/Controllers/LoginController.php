<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use App\Http\Requests\LoginUserRequest;
use Exception;
use Auth;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View
     */
	public function form(Request $request)
    {
        if(!Auth::check()) {
            return view('auth.login');
        }

        if($request->user()->role == 1) {
            return redirect('/home');
        }

        return redirect('/');
	}

    /**
     * @param LoginUserRequest $request
     * @return Application|RedirectResponse|Redirector
     */
	public function login(LoginUserRequest $request)
    {
        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                return redirect('/home');
            }
            return back()->withInput()->withErrors([
                'password' => 'Invalid credentials'
            ]);
        } catch(Exception $e) {
            dd($e);
            return back()->withInput()->withErrors([
                'password' => 'There was an error logging you in.'
            ]);
        }
	}
}
