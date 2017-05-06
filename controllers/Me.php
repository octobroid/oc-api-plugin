<?php namespace Octobro\API\Controllers;

use Octobro\API\Classes\ApiController;
use Octobro\API\Transformers\UserTransformer;

class Me extends ApiController
{
    public function show()
    {
        return $this->respondWithItem($this->user, new UserTransformer);
    }

    public function update()
    {
        $this->user->fill($this->data);

        if($this->input->has('avatar')) {
            $this->user->avatar = $this->base64ToFile($this->data['avatar']);
        }

        $this->user->save();

        return $this->respondWithItem($this->user, new UserTransformer);
    }

}
