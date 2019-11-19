<?php

namespace App\Actions\Task;

use App\Actions\Action;
use Illuminate\Http\Response;
use Modules\Task\Models\Task;

class EditTaskAction extends Action
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
        title('Edit Task');

        $task = $this->task;

        return view('task::pages.task.edit', compact('task'));
    }

    /**
     * Response to be returned in case of API request.
     *
     * @return mixed
     */
    protected function jsonResponse()
    {
        return response()->json($this->task, Response::HTTP_OK);
    }
}
