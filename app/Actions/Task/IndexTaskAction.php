<?php

namespace App\Actions\Task;

use App\Actions\Action;
use Illuminate\Http\Response;
use Modules\Task\DataTables\TaskDataTable;
use Modules\Task\Models\Task;

class IndexTaskAction extends Action
{
    protected $dataTable;

    public function __invoke(TaskDataTable $dataTable)
    {
        $this->dataTable = $dataTable;

        return $this->sendResponse();
    }

    /**
     * Response to be returned in case of web request.
     *
     * @return mixed
     */
    protected function htmlResponse()
    {
        title('Task List');

        return $this->dataTable->render('task::pages.task.index');
    }

    /**
     * Response to be returned in case of API request.
     *
     * @return mixed
     */
    protected function jsonResponse()
    {
        return response()->json(Task::all(), Response::HTTP_OK);
    }
}
