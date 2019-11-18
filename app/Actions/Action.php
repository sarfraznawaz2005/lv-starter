<?php

namespace App\Actions;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;

abstract class Action
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
    abstract protected function responseWeb();

    /**
     * Response to be returned in case of API request.
     *
     * @return mixed
     */
    abstract protected function responseApi();

    protected function sendResponse()
    {
        if ($this->isApi()) {

            if (!$this->authorize()) {
                return response()->json(null, Response::HTTP_NOT_FOUND);
            }

            return $this->responseApi();
        }

        abort_unless($this->authorize(), 404);

        return $this->responseWeb();
    }

    /**
     * Checks if current request is api by looking at accept json header.
     *
     * @return bool
     */
    protected function isApi(): bool
    {
        if (request()->expectsJson() && !request()->acceptsHtml()) {
            return true;
        }

        return false;
    }
}
