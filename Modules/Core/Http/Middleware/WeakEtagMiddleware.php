<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Weak ETag middleware.
 */
class WeakEtagMiddleware
{
    /**
     * Implement weak Etag support.
     * inspired by https://github.com/matthewbdaly/laravel-etag-middleware
     *
     * @param \Illuminate\Http\Request $request The HTTP request.
     * @param \Closure $next Closure for the response.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get response
        $response = $next($request);

        // If this was a GET request...
        if ($request->isMethod('get')) {
            // Generate Etag
            $etag = sha1($response->getContent());

            $requestEtag = str_replace('W/"', '', $request->getETags());
            $requestEtag = str_replace('"', '', $requestEtag);

            // Check to see if Etag has changed
            if ($requestEtag && $requestEtag[0] == $etag) {
                $response->setNotModified();
            }

            $response->setEtag($etag, true);
        }

        return $response;
    }
}
