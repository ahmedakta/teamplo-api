<?php

namespace App\Http\Controllers;
use App\Http\Controllers\TaskController;

use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }
    public function destroy($id)
    {
        try{
            $task = Task::findOrFail($id);
            if(!is_null($task))
            {
                $task->delete();
                return response()->json(['success' => 'OK'] , 200);
            }
        }catch(\Exception $error){
            return response()->json(['error' => $error->getMessage()] , 400);
        }
    }
}
