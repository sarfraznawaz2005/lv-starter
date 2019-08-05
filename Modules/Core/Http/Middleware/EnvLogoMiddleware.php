<?php

namespace Modules\Core\Http\Middleware;

use Closure;

class EnvLogoMiddleware
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
        $response = $next($request);

        $this->addLogo($response);

        return $response;
    }

    protected function addLogo($response)
    {
        if (app()->runningInConsole()) {
            return;
        }

        $env = strtoupper(app()->environment());

        $logo = <<< HTML
        <span style="background-image: radial-gradient(#70ff70, #35d635); padding:2px 5px 0 5px; width:auto; font-weight:bold; font-size:12px; font-family:arial,serif; position:fixed; bottom:0; left:0; z-index: 9999999999999999999999;">
        $env
        </span>
HTML;

        $content = $response->getContent();

        $bodyPosition = strripos($content, '</body>');

        if (false !== $bodyPosition) {
            $content = substr($content, 0, $bodyPosition) . $logo . substr($content, $bodyPosition);
        }

        $response->setContent($content);
    }
}
