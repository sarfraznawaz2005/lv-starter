<?php

namespace App\Actions\Task;

use App\Actions\Action;
use Illuminate\Http\Response;
use Modules\Task\Models\Task;

class DestroyTaskAction extends Action
{
    protected $task;

    public function __invoke(Task $task)
    {
        $this->task = $task;

        return $this->sendResponse();
    }

    /**
     * Response to be returned in case of web request.
     *
     * @return mixed
     */
    protected function htmlResponse()
    {
        if (!$this->task->delete()) {
            return back()->withErrors($this->task->getErrors());
        }

        flash('Deleted successfully', 'success');

        return back();
    }

    /**
     * Response to be returned in case of API request.
     *
     * @return mixed
     */
    protected function jsonResponse()
    {
        if (!$this->task->delete()) {
            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
