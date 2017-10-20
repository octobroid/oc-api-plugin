<?php namespace Octobro\API\Middleware;

use Closure;
use Octobro\API\Classes\Authorizer;

/**
 * This is the check auth code request middleware class.
 */
class CheckAuthCodeRequestMiddleware
{
    /**
     * The authorizer instance.
     *
     * @var \Octobro\API\Classes\Authorizer
     */
    protected $authorizer;

    /**
     * Create a new check auth code request middleware instance.
     *
     * @param \Octobro\API\Classes\Authorizer $authorizer
     */
    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->authorizer->setRequest($request);

        $this->authorizer->checkAuthCodeRequest();

        return $next($request);
    }
}
