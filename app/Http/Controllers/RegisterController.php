<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Services\UserService;
use Exception;
use Auth;

class RegisterController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * RegisterController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return Application|Factory|View
     */
    public function form(Request $request)
    {
        if(!Auth::check()) {
            return view('auth.register');
        }

        if($request->user()->role == 1) {
            return redirect('/home');
        }

        return redirect('/');
    }

    /**
     * @param RegisterUserRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function register(RegisterUserRequest $request)
    {
        if ($request->password != $request->password_confirmation) {
            return back()->withInput()->withErrors([
                'password' => 'Passwords must match'
            ]);
        }
        try {
            $user = $this->userService->create($request->name, $request->email, $request->password, 0);
            Auth::login($user);
            return redirect('/home');
        } catch (Exception $e) {
            return back()->withInput()->withErrors([
                'email' => 'There is already an account with this email'
            ]);
        }
    }
}
