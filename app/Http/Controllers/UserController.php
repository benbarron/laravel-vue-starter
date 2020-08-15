<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Models\User;
use Exception;
use Illuminate\Http\Response;

class UserController extends Controller
{

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __constructor(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return User
     */
    public function current(Request $request)
    {
        return $request->user();
    }

    /**
     * @param Request $request
     * @return User
     */
    public function all(Request $request)
    {
        return $this->userService->allButSelf($request->user()->id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function findById(Request $request, $id)
    {
        try {
            $user = User::where('id', '=', $id)->firstOrFail();
            return response($user, 200);
        } catch (Exception $e) {
            return response([
                'message' => 'No user found with id ' . $id
            ], 404);
        }
    }

    /**
     * @param CreateUserRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function store(CreateUserRequest $request)
    {
        try {
            $user = $this->userService->create(
                $request->name,
                $request->email,
                $request->password,
                $request->role
            );

            return response([
                'message' => 'User created with email ' . $request->email,
                'user' => $user
            ], 201);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()], 501);
        }
    }

    /**
     * @param UpdateUserRequest $request
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $this->userService->update($id, $request->name, $request->email);
            return response(['message' => 'User has been updated'], 201);
        } catch (Exception $e) {
            return response(['message' => 'Error updating user'], 501);
        }
    }
}
