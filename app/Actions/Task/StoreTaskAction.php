<?php

namespace App\Actions\Task;

use App\Actions\Action;
use Illuminate\Http\Response;
use Modules\Task\Models\Task;

class StoreTaskAction extends Action
{
    protected $task;

    protected function authorize(): bool
    {
        return true;
    }

    public function execute(Task $task)
    {
        $this->task = $task;

        request()->request->add(['user_id' => 1]);

        $this->task->fill(request()->all());

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

        return response()->json($this->task, Response::HTTP_CREATED);
    }
}
