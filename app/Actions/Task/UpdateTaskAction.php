<?php

namespace App\Actions\Task;

use App\Actions\Action;
use Illuminate\Http\Response;
use Modules\Task\Models\Task;

class UpdateTaskAction extends Action
{
    protected $task;

    /**
     * Define any validation rules.
     *
     * @return mixed
     */
    protected function rules(): array
    {
        return [
            'description' => 'required|min:5',
        ];
    }

    public function __invoke(Task $task)
    {
        $this->task = $task;

        $this->task->fill($this->validData);

        return $this->sendResponse();
    }

    /**
     * Response to be returned in case of web request.
     *
     * @return mixed
     */
    protected function htmlResponse()
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
    protected function jsonResponse()
    {
        if (!$this->task->save()) {
            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($this->task, Response::HTTP_OK);
    }
}
