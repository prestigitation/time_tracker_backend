<?php

namespace App\Http\Controllers;

use App\Http\Repository\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->replace([
            'task' => json_decode($request->task),
            'subtasks' => json_decode($request->subtasks)
        ]);
        // распаковываем json с клиента

        $unvalidatedData = TaskRepository::validated($request);
        if(count($unvalidatedData) > 0) {
            return new JsonResponse(['message' => 'Не удалось добавить задачу', 'data' => $unvalidatedData]);
        } else {
            $task = TaskRepository::createTask($request);
            return new Response($task);
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
        //
    }
}
