<?php namespace Octobro\API\Transformers;

use RainLab\User\Models\User;
use Octobro\API\Classes\Transformer;

class UserTransformer extends Transformer
{
    public function transform(User $user)
    {
        return [
            'id'         => (int) $user->id,
            'name'       => $user->name,
            'username'   => $user->username,
            'email'      => $user->email,
            'last_login' => date($user->last_login),
        ];
    }

}