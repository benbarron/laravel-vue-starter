<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use Exception;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * @return Application|Factory|View
     */
	public function form()
    {
	    return view('auth.login');
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
            return back()->withInput()->withErrors([
                'password' => 'There was an error logging you in.'
            ]);
        }
	}
}
