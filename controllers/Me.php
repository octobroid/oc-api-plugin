<?php namespace Octobro\API\Controllers;

use URL;
use Input;
use Mail;
use Response;
use Validator;
use Exception;
use Authorizer;
use Auth as AuthBase;
use ValidationException;
use RainLab\User\Models\User;
use Octobro\API\Transformers\UserTransformer;

class Me extends ApiController
{
    public function show()
    {
        return $this->respondWithItem($this->user, new UserTransformer);
    }

    public function update()
    {
        $data = Input::get();

        $this->user->fill($data);

        $this->user->save();

        return $this->respondWithItem($this->user, new UserTransformer);
    }

}
