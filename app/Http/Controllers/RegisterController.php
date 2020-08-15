<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Services\UserService;
use Exception;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

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
    public function form()
    {
        return view('auth.register');
    }

    /**
     * @param RegisterUserRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function register(RegisterUserRequest $request)
    {
        if ($request->password != $request->password_confirmation) {
            return back()->withErrors([
                'password' => 'Passwords must match'
            ]);
        }
        try {
            $user = $this->userService->create($request->name, $request->email, $request->password, 0);
            Auth::login($user);
            return redirect('/home');
        } catch (Exception $e) {
            return back()->withInput();
        }
    }
}
