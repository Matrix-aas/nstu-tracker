<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\ResponseFactory;
use phpDocumentor\Reflection\Types\String_;

class JsonMiddleware
{
    /** @var ResponseFactory */
    protected $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        /** @var Response $response */
        $response = $next($request);

        if (is_string($response->getOriginalContent())) {
            $response = new JsonResponse([
                'message' => $response->getOriginalContent(),
                'status' => $response->status()
            ], $response->status(), $response->headers->all());
        } else if (is_bool($response->getOriginalContent())) {
            $response = new JsonResponse([
                'message' => $response->getOriginalContent() ? 'success' : 'fail',
                'status' => $response->status()
            ], $response->status(), $response->headers->all());
        } else {
            $content = json_decode($response->content(), true);
            if (is_array($content)) {
                $response = new JsonResponse([
                    'message' => '',
                    'status' => $response->status(),
                    'data' => $content
                ], $response->status(), $response->headers->all());
            }
        }

        return $response;
    }
}
