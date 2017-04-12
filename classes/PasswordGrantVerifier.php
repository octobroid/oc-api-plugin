<?php namespace Octobro\API\Classes;

use Auth;

class PasswordGrantVerifier
{
    public function verify($username, $password)
    {
        $credentials = [
            'username' => $username,
            'password' => $password,
        ];

        if ($user = Auth::authenticate($credentials)) {
            return $user->id;
        }

        return false;
    }
}