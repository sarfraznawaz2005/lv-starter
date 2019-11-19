<?php

/*
 *
 * php artisan make:action with params https://github.com/hivokas/laravel-handlers
 *
 *
 *
 *
 *
 * */


namespace App\Actions;

use BadMethodCallException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

abstract class Action extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Execute the action.
     *
     * @param string $method
     * @param array $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        if ($method !== '__invoke') {
            throw new BadMethodCallException('Only __invoke method can be called on action.');
        }

        return call_user_func_array([$this, $method], $parameters);
    }

    /**
     * Authorize current action.
     *
     * @return mixed
     */
    abstract protected function authorize();

    /**
     * Response to be returned in case of web request.
     *
     * @return mixed
     */
    abstract protected function htmlResponse();

    /**
     * Response to be returned in case of API request.
     *
     * @return mixed
     */
    abstract protected function jsonResponse();

    protected function sendResponse()
    {
        if ($this->isApi()) {

            if (!$this->authorize()) {
                return response()->json(null, Response::HTTP_NOT_FOUND);
            }

            return $this->jsonResponse();
        }

        abort_unless($this->authorize(), 404);

        return $this->htmlResponse();
    }

    /**
     * Checks if current request is api by looking at accept json header.
     *
     * @return bool
     */
    protected function isApi(): bool
    {
        return request()->expectsJson() && !request()->acceptsHtml();
    }
}
