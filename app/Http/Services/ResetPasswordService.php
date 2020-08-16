<?php


namespace App\Http\Services;

use App\Http\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class ResetPasswordService
{
    protected $redisClient;

    public function __construct()
    {
        $this->redisClient = Redis::connection('password_reset')->client();
    }

    /**
     * @param string $userId
     * @param string $token
     * @return boolean
     */
    public function verifyToken(string $userId, string $token)
    {
        $storedValue = $this->redisClient->get($this->formatKey($userId));
        return $storedValue == $token;
    }

    /**
     * @param string $email
     */
    public function sendResetEmail(string $email)
    {
        $user = User::where('email', '=', $email)->first();
        if($user) {
            $token = $this->generateToken();
            $this->setToken($user->id, $token);
            $user->notify(new PasswordResetNotification($token));
        }
    }

    /**
     * @param $id
     */
    public function clear($id)
    {
        $this->redisClient->del($key = $this->formatKey($id));
    }

    private function formatKey($id)
    {
        return 'PASSWORD_RESET:'.$id;
    }

    /**
     * @return string
     */
    private function generateToken()
    {
        return Str::random(60);
    }

    /**
     * @param string $userId
     * @param string $token
     */
    private function setToken(string $userId, string $token)
    {
        $this->redisClient->set($this->formatKey($userId), $token, 600);
    }
}
