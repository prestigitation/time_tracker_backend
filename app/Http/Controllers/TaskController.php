<?php

namespace App\Http\Controllers;

use App\Http\Repository\TaskRepository;
use App\Http\Requests\SyncTimeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TaskRepository::getAllTasks();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $request->replace([
            'task' => json_decode($request->task),
            'subtasks' => json_decode($request->subtasks)
        ]);
        // распаковываем json с клиента

        $unvalidatedData = TaskRepository::validated($request);
        if(count($unvalidatedData) > 0) {
            return new JsonResponse(['message' => 'Не удалось добавить задачу', 'data' => $unvalidatedData], 422);
        } else {
            TaskRepository::createTask($request);
            return new JsonResponse(['message' => 'Задача была успешно добавлена!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if(Gate::allows('modify_post', $task)) {
            return TaskRepository::deleteTask($task);
        } else return new JsonResponse(['message' => 'Нету необходимых прав для удаления задачи'], 403);
    }

    public function syncTaskTime(SyncTimeRequest $request)
    {
        return TaskRepository::syncTime($request->validated());
    }

    public function addFile(int $taskId, Request $request)
    {
        $task = Task::findOrFail($taskId);
        if(Gate::allows('modify_post', $task)) {
            TaskRepository::addFile($task, $request);
            return new JsonResponse(['message' => 'Файл был успешно добавлен']);
        } else return new JsonResponse(['message' => 'Нету необходимых прав для удаления задачи'], 403);
    }
}
