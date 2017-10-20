<?php namespace Octobro\API\Middleware;

use Closure;
use League\OAuth2\Server\Exception\InvalidScopeException;
use Octobro\API\Classes\Authorizer;

/**
 * This is the oauth middleware class.
 */
class OAuthMiddleware
{
    /**
     * The Authorizer instance.
     *
     * @var \Octobro\API\Classes\Authorizer
     */
    protected $authorizer;

    /**
     * Whether or not to check the http headers only for an access token.
     *
     * @var bool
     */
    protected $httpHeadersOnly = false;

    /**
     * Create a new oauth middleware instance.
     *
     * @param \Octobro\API\Classes\Authorizer $authorizer
     * @param bool $httpHeadersOnly
     */
    public function __construct(Authorizer $authorizer, $httpHeadersOnly = false)
    {
        $this->authorizer = $authorizer;
        $this->httpHeadersOnly = $httpHeadersOnly;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $scopesString
     *
     * @throws \League\OAuth2\Server\Exception\InvalidScopeException
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $scopesString = null)
    {
        $scopes = [];

        if (!is_null($scopesString)) {
            $scopes = explode('+', $scopesString);
        }

        $this->authorizer->setRequest($request);

        $this->authorizer->validateAccessToken($this->httpHeadersOnly);
        $this->validateScopes($scopes);

        return $next($request);
    }

    /**
     * Validate the scopes.
     *
     * @param $scopes
     *
     * @throws \League\OAuth2\Server\Exception\InvalidScopeException
     */
    public function validateScopes($scopes)
    {
        if (!empty($scopes) && !$this->authorizer->hasScope($scopes)) {
            throw new InvalidScopeException(implode(',', $scopes));
        }
    }
}
