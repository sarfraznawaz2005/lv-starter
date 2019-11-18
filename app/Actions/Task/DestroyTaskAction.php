<?php

namespace App\Actions\Task;

use App\Actions\Action;
use Illuminate\Http\Response;
use Modules\Task\Models\Task;

class DestroyTaskAction extends Action
{
    protected $task;

    protected function authorize(): bool
    {
        return $this->task->user_id === 1;
    }

    public function execute(Task $task)
    {
        $this->task = $task;

        return $this->sendResponse();
    }

    /**
     * Response to be returned in case of web request.
     *
     * @return mixed
     */
    protected function responseWeb()
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
    protected function responseApi()
    {
        if (!$this->task->delete()) {
            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
