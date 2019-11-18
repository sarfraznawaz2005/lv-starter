<?php

namespace App\Actions\Task;

use App\Actions\Action;
use Illuminate\Http\Response;
use Modules\Task\DataTables\TaskDataTable;
use Modules\Task\Models\Task;

class IndexTaskAction extends Action
{
    protected $dataTable;

    public function __construct(TaskDataTable $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    protected function authorize(): bool
    {
        return true;
    }

    public function execute()
    {
        return $this->sendResponse();
    }

    /**
     * Response to be returned in case of web request.
     *
     * @return mixed
     */
    protected function responseWeb()
    {
        title('Task List');

        return $this->dataTable->render('task::pages.task.index');
    }

    /**
     * Response to be returned in case of API request.
     *
     * @return mixed
     */
    protected function responseApi()
    {
        return response()->json(Task::all(), Response::HTTP_OK);
    }
}
