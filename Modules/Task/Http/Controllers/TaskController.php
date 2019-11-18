<?php

namespace Modules\Task\Http\Controllers;

use App\Actions\Task\CompleteTaskAction;
use App\Actions\Task\DestroyTaskAction;
use App\Actions\Task\EditTaskAction;
use App\Actions\Task\IndexTaskAction;
use App\Actions\Task\StoreTaskAction;
use App\Actions\Task\UpdateTaskAction;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Task\Models\Task;

class TaskController extends CoreController
{
    public function index(IndexTaskAction $action)
    {
        return $action->execute();
    }

    public function store(Task $task, StoreTaskAction $action)
    {
        return $action->execute($task);
    }

    public function edit(Task $task, EditTaskAction $action)
    {
        return $action->execute($task);
    }

    public function update(Task $task, UpdateTaskAction $action)
    {
        return $action->execute($task);
    }

    public function destroy(Task $task, DestroyTaskAction $action)
    {
        return $action->execute($task);
    }

    public function complete(Task $task, CompleteTaskAction $action)
    {
        return $action->execute($task);
    }
}
