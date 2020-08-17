<?php

namespace App\Http\Controllers;

use App\Http\Services\ResetPasswordService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class ForgotPasswordController
 * @package App\Http\Controllers
 */
class ForgotPasswordController extends Controller
{
    /**
     * @var ResetPasswordService
     */
    protected $resetPasswordService;

    /**
     * ForgotPasswordController constructor.
     * @param ResetPasswordService $passwordResetService
     */
    public function __construct(ResetPasswordService $passwordResetService)
    {
        $this->resetPasswordService = $passwordResetService;
    }

    /**
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('auth.reset-email');
    }

    /**
     * @param Request $request
     * @return Application|Factory|RedirectResponse|View
     */
    public function send(Request $request)
    {
        $email = $request->input('email');

        if(!$email) {
            return back()->withErrors([
                'email' => 'Please enter an email address'
            ]);
        }

        $this->resetPasswordService->sendResetEmail($email);
        return view('auth.reset-sent')->with([
            'email' => $email
        ]);
    }
}
