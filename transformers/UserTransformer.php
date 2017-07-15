<?php namespace Octobro\API\Transformers;

use RainLab\User\Models\User;
use Octobro\API\Classes\Transformer;

class UserTransformer extends Transformer
{
    public $availableIncludes = [
        'groups',
    ];

    public function data(User $user)
    {
        return [
            'id'         => (int) $user->id,
            'name'       => $user->name,
            'username'   => $user->username,
            'email'      => $user->email,
            'last_login' => date($user->last_login),
            'avatar'     => $this->image($user->avatar),
        ];
    }

    public function includeGroups(User $user)
    {
        return $this->collection($user->groups, new UserGroupTransformer);
    }

}