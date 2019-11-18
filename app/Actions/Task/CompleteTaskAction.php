<?php

namespace App\Actions\Task;

use App\Actions\Action;
use Illuminate\Http\Response;
use Modules\Task\Models\Task;

class CompleteTaskAction extends Action
{
    protected $task;

    protected function authorize(): bool
    {
        return $this->task->user_id === 1;
    }

    public function execute(Task $task)
    {
        $this->task = $task;

        $this->task->completed = !$this->task->completed;

        return $this->sendResponse();
    }

    /**
     * Response to be returned in case of web request.
     *
     * @return mixed
     */
    protected function responseWeb()
    {
        if (!$this->task->save()) {
            return back()->withErrors($this->task->getErrors());
        }

        flash('Saved successfully', 'success');

        return back();
    }

    /**
     * Response to be returned in case of API request.
     *
     * @return mixed
     */
    protected function responseApi()
    {
        if (!$this->task->save()) {
            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($this->task, Response::HTTP_OK);
    }
}
