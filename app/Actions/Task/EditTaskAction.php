<?php

namespace App\Actions\Task;

use App\Actions\Action;
use Illuminate\Http\Response;
use Modules\Task\Models\Task;

class EditTaskAction extends Action
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
        title('Edit Task');

        $task = $this->task;

        return view('task::pages.task.edit', compact('task'));
    }

    /**
     * Response to be returned in case of API request.
     *
     * @return mixed
     */
    protected function responseApi()
    {
        return response()->json($this->task, Response::HTTP_OK);
    }
}
