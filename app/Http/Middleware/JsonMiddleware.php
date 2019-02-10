<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class JsonMiddleware
{
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

        $response->headers->set('Content-Type', 'application/json');

        if (is_string($response->getOriginalContent())) {
            $response = new JsonResponse([
                'message' => $response->getOriginalContent(),
                'status' => $response->status()
            ], $response->status(), $response->headers->all());
        } else {
            $content = json_decode($response->content(), true);
            if (is_array($content)) {
                $data = [
                    'status' => $response->status(),
                    'message' => isset($content['message']) ? $content['message'] : ($response->status() == 200 ? 'OK' : 'Error'),
                    'data' => $content
                ];
                if (count($content) == 1 && isset($content['message'])) {
                    unset($data['data']);
                }
                $response = new JsonResponse($data, $response->status(), $response->headers->all());
            }
        }

        return $response;
    }
}
