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
            return $this->respondWithArray((Authorizer::issueAccessToken()));
        } catch (Exception $e) {
            return $this->errorWrongArgs($e->getMessage());
        }
    }

    public function register()
    {
        try {

            /*
             * Validate input
             */
            $data = $this->data;

            if (!array_key_exists('password_confirmation', $data)) {
                $data['password_confirmation'] = post('password');
            }

            $rules = [
                'name'     => 'required',
                'email'    => 'required|email|between:6,255',
                'password' => 'required|between:4,255',
            ];

            $validation = Validator::make($data, $rules);
            if ($validation->fails()) {
                throw new ValidationException($validation);
            }

            // Register, no need activation
            $user = AuthBase::register($data, true);

            return Response::json(Authorizer::issueAccessToken());

        } catch (Exception $e) {
            return $this->errorWrongArgs($e->getMessage());
        }
    }

    public function forgot()
    {
    }

}
