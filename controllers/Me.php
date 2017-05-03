<?php namespace Octobro\API\Controllers;

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
        $this->user->save();

        return $this->respondWithItem($this->user, new UserTransformer);
    }

}
