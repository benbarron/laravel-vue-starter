<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Services\ResetPasswordService;
use App\Http\Services\UserService;

/**
 * Class ResetPasswordController
 * @package App\Http\Controllers
 */
class ResetPasswordController extends Controller
{
    /**
     * @var ResetPasswordService
     */
    private $resetPasswordService;

    /**
     * @var UserService
     */
    private $userService;


    public function __construct(ResetPasswordService $resetPasswordService, UserService $userService)
    {
        $this->resetPasswordService = $resetPasswordService;
        $this->userService = $userService;
    }

    public function show(string $token, $id)
    {
        if(!$this->resetPasswordService->verifyToken($id, $token)) {
            return view('auth.reset-invalid');
        }
        view()->share('userId', $id);
        view()->share('token', $token);
        return view('auth.reset-password');
    }

    public function update(ResetPasswordRequest $request)
    {
        if(!$this->resetPasswordService->verifyToken($request->userId, $request->token)) {
            return view('auth.reset-invalid');
        }
        $this->resetPasswordService->clear($request->userId);
        $this->userService->updatePassword($request->userId, $request->password);
        return view('auth.reset-updated');
    }
}
