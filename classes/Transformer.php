<?php namespace Octobro\API\Classes;

use Closure;
use League\Fractal\Scope;
use League\Fractal\TransformerAbstract;

abstract class Transformer extends TransformerAbstract
{
    use \October\Rain\Extension\ExtendableTrait;

    public $implement;

    public $defaultIncludes = [];

    public $availableIncludes = [];

    /**
     * Instantiate a new BackendController instance.
     */
    public function __construct()
    {
        $this->extendableConstruct();
    }

    /**
     * Extend this object properties upon construction.
     */
    public static function extend(Closure $callback)
    {
        self::extendableExtendCallback($callback);
    }

    /**
     * Perform dynamic methods
     */
    public function __call($method, $parameters)
    {
        if (isset($this->extensionData['dynamicMethods'][$method])) {
            return call_user_func_array($this->extensionData['dynamicMethods'][$method], $parameters);
        }

        return call_user_func_array([$this, $method], $parameters);
    }

}