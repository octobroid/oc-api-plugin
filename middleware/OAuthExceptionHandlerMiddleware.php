<?php namespace Octobro\API\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use League\OAuth2\Server\Exception\OAuthException;

/**
 * This is the exception handler middleware class.
 */
class OAuthExceptionHandlerMiddleware
{
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
        try {
            $response = $next($request);
            // Was an exception thrown? If so and available catch in our middleware
            if (isset($response->exception) && $response->exception) {
                throw $response->exception;
            }

            return $response;
        } catch (OAuthException $e) {
            $data = [
                'error' => $e->errorType,
                'error_description' => $e->getMessage(),
            ];

            return new JsonResponse($data, $e->httpStatusCode, $e->getHttpHeaders());
        }
    }
}
