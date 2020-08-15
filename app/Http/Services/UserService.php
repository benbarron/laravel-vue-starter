<?php

namespace App\Http\Services;

use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService {

    /**
     * @param Request $request
     * @return User
     */
	public function allButSelf($id)
    {
		return User::where('id', '!=', $id)->get();
	}

	/**
	 * @param string $name
     * @param string $email
     * @param string $password
     * @param int $role
     * @throws Exception
     */
	public function create(string $name, string $email, string $password, int $role)
    {
		if($this->existsWithEmail($email)) {
			throw new Exception('Account exists with email '.$email);
		}
		$user =  User::make([
			'name' => $name,
			'email' => $email,
			'password' => Hash::make($password),
			'api_token' => Str::random(60),
			'role' => $role
		]);
		$user->save();
		return $user;
	}

    /**
     * @param string $id
     * @param string $name
     * @param string $email
     * @return mixed
     * @throws Exception
     */
	public function update(string $id, string $name, string $email)
    {
		if($this->existsWithEmail($email)) {
			throw new Exception('Account exists with email '.$email);
		}
		$user = User::where('id', '=', $id)->firstOrFail();
		$user->name = $name;
		$user->email = $email;
		$user->save();
		return $user;
	}

    /**
     * @param string $id
     */
	public function deleteById(string $id)
    {
		User::where('id', '=', $id)->delete();
	}

    /**
     * @param string $email
     * @return bool
     */
	public function existsWithEmail(string $email)
    {
		$existingUser = User::where('email', '=', $email)->get();
		return count($existingUser) > 0;
	}

}
