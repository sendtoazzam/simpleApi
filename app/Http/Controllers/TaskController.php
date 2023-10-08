<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;

class TaskController extends ApiController
{
    public function index()
    {
        $task = Task::all();

        if ($task->count() == 0) {
            return $this->successResponse("No task available");
        }
        return $this->successResponse($task);
    }

    public function store(Request $req)
    {

        try {
            $validator = Validator::make(
                ['title' => ['required', 'min:5', 'max:15']],
                ['description' => ['min:5', 'max:255']]
            );

            if ($validator->fails()) {
                return $this->errorResponse($validator->fails(), 422);
            }
            
            $task = new Task;
            $task->title = $req->title;
            $task->description = is_null($req->description) ? null : $req->description;
            $task->status = 'Open';
            $task->save();

            return $this->successResponse("New task created successfully");
        } catch (Exception $e) {
            return $this->errorResponse($e, $e->getCode());
        }
    }

    public function getById($id)
    {
        $task = Task::where('taskId', $id)->first();

        if (empty($task))
            return $this->successResponse("Task id:" . $id . " not found");

        return $this->successResponse($task);
    }

    public function update(Request $req, $id)
    {
        if (Task::where('taskId', $id)->exists()) {
            $task = Task::where('taskId', $id)->first();
            Task::where('taskId', $id)
                ->update([
                    'title' => is_null($req->title) ? $task->title : $req->title,
                    'description' => is_null($req->description) ? $task->description : $req->description,
                    'updated_at' => Carbon::now()
                ]);

                return $this->successResponse([], "Task Updated");
        } else {
            return $this->successResponse("Task id:" . $id . " not found");
        }
    }

    public function delete($id)
    {
        if (Task::where('taskId', $id)->exists()) {
            Task::where('taskId', $id)->delete();

            return $this->successResponse([], "Task deleted");
        } else {
            return $this->successResponse("Task id:" . $id . " not found");
        }
    }

    public function complete($id)
    {
        if (Task::where('taskId', $id)->exists()) {
            $task = Task::where('taskId', $id)->first();
            if ($task->status === 'Completed') {
                return $this->errorResponse("Task id: ". $id . " already marked as Completed", 422);
            }

            Task::where('taskId', $id)
                ->update([
                    'status' => 'Completed',
                    'updated_at' => Carbon::now()
                ]);

                return $this->successResponse([], "Task marked as Completed");
        } else {
            return $this->successResponse("Task id:" . $id . " not found");
        }
    }
}
