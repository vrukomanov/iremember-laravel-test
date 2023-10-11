<?php

namespace App\Http\Controllers;

use App\Enum\TaskStatus;
use App\Jobs\TasksManagerCreate;
use App\Jobs\TasksManagerUpdate;
use App\Models\Task;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return $this->success([
            'tasks' => Task::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|max:255|unique:tasks',
            'status' => [new Enum(TaskStatus::class)]
        ]);

        if ($validator->fails()) {
            return $this->error(data: $validator->errors()->messages(), code: 400);
        }

        dispatch(new TasksManagerCreate(
            description: $request->description,
            status: $request->status
        ));

        return $this->success(message: "Task stored");
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): Response
    {
        return $this->success([
            'task' => $task
        ]);
    }

    public function edit(Task $task): Response
    {
        return $this->success([
            'task' => $task
        ]);
    }

    public function update(Request $request, Task $task): Response
    {
        $validator = Validator::make($request->all(), [
            'description' => 'max:255|unique:tasks',
            'status' => [new Enum(TaskStatus::class)]
        ]);

        if ($validator->fails()) {
            return $this->error(data: $validator->errors()->messages(), code: 400);
        }

        dispatch(new TasksManagerUpdate(
            id: $task->getKey(),
            description: $request->description,
            status: $request->status
        ));

        return $this->success(message: "Task update requested");
    }

    public function destroy(Task $task): Response
    {
        $removalId = $task->getKey();

        if(!$task->delete()){
            return $this->error(message: "Delete failed", code: 400);
        }

        return $this->success([
            'task' => $removalId
        ]);
    }
}
