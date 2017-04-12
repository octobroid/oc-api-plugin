<?php namespace Octobro\API\Controllers;

use URL;
use Mail;
use Response;
use Validator;
use Exception;
use Authorizer;
use Auth as AuthBase;
use ValidationException;
use RainLab\User\Models\User;

class Auth extends ApiController
{
    public function accessToken()
    {
        try {
            return Response::json(Authorizer::issueAccessToken());
        } catch (Exception $e) {
            return $this->errorWrongArgs($e->getMessage());
        }
    }

    public function register()
    {
    }

    public function forgot()
    {
    }

}
