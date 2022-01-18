<?php
namespace App\Http\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Priority;

class TaskRepository {
    public static function validated(Request $request): array
    {
        $taskRequest = new StoreTaskRequest();
        $subtaskValidationErrors = [];

        foreach($request->subtasks as $index => $subtask)
        {
            $subtaskLoopValidator = Validator::make((array)$subtask, $taskRequest->rules(), $taskRequest->messages());
            $errors = $subtaskLoopValidator->errors()->messages();
            if(count($errors) > 0) {
                $subtaskValidationErrors[$index] = $errors;
            }
        }


        $taskValidation = Validator::make((array)$request->task, $taskRequest->rules(), $taskRequest->messages());
        $taskValidationErrors = $taskValidation->errors()->messages();

        $fileValidationErrors = Validator::make($request->all(), [
            'files' => 'array|nullable',
            'files.*' => 'mimes:jpg,bmp,png|max:4096'
        ])->errors()->messages();

        if(count($subtaskValidationErrors) > 0 ||
                count($taskValidationErrors) > 0 ||
                count($fileValidationErrors) > 0) {
            return [
                'subtask' => [...$subtaskValidationErrors],
                'files' => [...$fileValidationErrors],
                'task' => [...$taskValidationErrors]
            ];
        } else return [];
    }

    public static function createTask(Request $request): void
    {
        $taskRequest = $request->task;
        $files = $request->file('files');
        $filePaths = [];
        $priorityId = Priority::find(1)->id;
        if($files && count($_FILES) > 0) {
            foreach($files as $file) {
                $uploadedFilePath = $file->store('tasks', 'public');
                array_push($filePaths, $uploadedFilePath);
            }
        }
        $task = Task::create([
            'description' => $taskRequest->description,
            'title' => $taskRequest->title,
            'ended_at' => Carbon::parse($taskRequest->ended_at)->toDateTimeString() ?? null,
            'subtasks' => json_encode($request->get('subtasks')) ?? [],
            'files' => json_encode($filePaths) ?? [],
            'priority_id' => $priorityId ?? null
        ]);


        if(Auth::user()) {
            $task->users()->attach(Auth::user());
        }
    }
}
