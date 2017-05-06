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


    protected function file($file)
    {
        if (!$file)
            return null;

        return array_only($file->toArray(), ['file_name', 'file_size', 'path']);
    }

    protected function image($file, Array $customSizes = [])
    {
        if (!$file)
            return null;

        $image = [
            'original' => $file->path,
        ];

        $sizes = array_merge([
            'small' => [160, 160, 'crop'],
            'medium' => [240, 240, 'crop'],
            'large' => [800, 800, 'crop'],
            'thumb' => [480, 480],
        ], $customSizes);

        foreach ($sizes as $name => $size) {
            $image[$name] = call_user_func_array([$file, 'getThumb'], $size);
        }

        return $image;
    }

}