<?php

namespace Modules\Task\Http\Controllers\API;

use App\Actions\Task\EditTaskAction;
use Modules\Task\Http\Controllers\TaskController;
use Modules\Task\Models\Task;

class TaskAPIController extends TaskController
{
    public function show(Task $task, EditTaskAction $action)
    {
        return $action->execute($task);
    }
}
