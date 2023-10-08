<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $task = Task::all();

        if ($task->count() == 0) {
            return response()->json([
                "message" => "No task available"
            ]);
        }
        return response()->json([
            "data" => $task
        ]);
    }

    public function store(Request $req)
    {

        try {
            $validator = Validator::make(
                ['title' => ['required', 'min:5', 'max:15']],
                ['description' => ['min:5', 'max:255']]
            );

            if ($validator->fails()) {
                return response()->json([
                    "message" => $validator->failed()
                ]);
            }
            
            $task = new Task;
            $task->title = $req->title;
            $task->description = is_null($req->description) ? null : $req->description;
            $task->status = 'Open';
            $task->save();

            return response()->json([
                "message" => "New task created succesfully."
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => $e
            ]);
        }
    }

    public function getById($id)
    {
        $task = Task::where('taskId', $id)->first();

        if (empty($task))
            return response()->json([
                "message" => "Task id:" . $id . " not found"
            ], 404);

        return response()->json([
            "data" => $task
        ]);
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

            return response()->json([
                "message" => "Task Updated"
            ], 200);
        } else {
            return response()->json([
                "message" => "Task id:" . $id . " not found"
            ], 404);
        }
    }

    public function delete($id)
    {
        if (Task::where('taskId', $id)->exists()) {
            Task::where('taskId', $id)->delete();

            return response()->json([
                "message" => "Task deleted"
            ], 200);
        } else {
            return response()->json([
                "message" => "Task id:" . $id . " not found"
            ], 404);
        }
    }

    public function complete($id)
    {
        if (Task::where('taskId', $id)->exists()) {
            $task = Task::where('taskId', $id)->first();
            if ($task->status === 'Completed') {
                return response()->json([
                    "status" => 422,
                    "message" => "Task is already marked as completed"
                ], 422);
            }

            Task::where('taskId', $id)
                ->update([
                    'status' => 'Completed',
                    'updated_at' => Carbon::now()
                ]);

            return response()->json([
                "message" => "Task marked as completed"
            ], 200);
        } else {
            return response()->json([
                "message" => "Task id:" . $id . " not found"
            ], 404);
        }
    }
}
