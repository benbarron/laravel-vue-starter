<?php

namespace App\Http\Services;

use App\Http\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService {

    /**
     * @param $id
     * @return User
     */
	public function allButSelf($id)
    {
		return User::where('id', '!=', $id)->get()->map->format();
	}

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param int $role
     * @throws Exception
     * @return User
     */
	public function create(string $name, string $email, string $password, int $role)
    {
		if($this->existsWithEmail($email)) {
			throw new Exception('Account exists with email '.$email);
		}
		$user = new User();
		$user->name = $name;
		$user->email = $email;
		$user->password = Hash::make($password);
        $user->api_token = Str::random(60);
        $user->role = $role;
		$user->save();
		return $user;
	}

    /**
     * @param string $id
     * @param string $name
     * @param string $email
     * @param int $role
     * @return mixed
     * @throws Exception
     */
	public function update(string $id, string $name, string $email, int $role)
    {
		if($this->existsWithEmailAndNotId($id, $email)) {
			throw new Exception('Account exists with email '.$email);
		}
		$user = User::where('id', '=', $id)->firstOrFail();
		$user->name = $name;
		$user->email = $email;
		$user->role = $role;
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

    /**
     * @param $id
     * @return mixed
     */
	public function findById($id)
    {
        return User::where('id', '=', $id)->firstOrFail();
    }

    /**
     * @param string $email
     * @param string $id
     * @return bool
     */
    public function existsWithEmailAndNotId(string $id, string $email)
    {
        $existingUser = User::where('email', '=', $email)
            ->where('id', '!=', $id)->get();

        return count($existingUser) > 0;
    }

    /**
     * @param $userId
     * @param $password
     */
    public function updatePassword($userId, $password)
    {
        $user = $this->findById($userId);
        $user->password = Hash::make($password);
        $user->save();
    }
}
