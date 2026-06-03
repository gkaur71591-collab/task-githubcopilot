<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
 /**
     * Validate request and create a new task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
class TaskController extends Controller
{
    /**
     * Return all tasks as JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tasks = Task::all();

        return response()->json($tasks, 200);
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $task = Task::create($validated);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task,
        ], 201);
    }

    /**
     * Validate request and update an existing task by id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $task = Task::findOrFail($id);

        $task->update($validated);

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task,
        ], 200);
    }

    /**
     * Delete an existing task by id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
            'id' => $id,
        ], 200);
    }
}
