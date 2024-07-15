<?php

namespace App\Http\Controllers;
use App\Http\Controllers\TaskController;
use App\Models\Department;
use App\Models\Task;

class TaskController extends Controller
{
    public function index($department_slug , $project_slug)
    {
        // gettin data
        $department = Department::where('slug' , $department_slug)->first();
        $project = $department->projects->where('slug' , $project_slug)->first();
        $department_project_tasks = $project->tasks;
        // set the data;
        $data['data']['tasks'] = $department_project_tasks;
        $data['data']['project'] = $project;
        $data['data']['department'] = $department;
        return response()->json(['data' => $data , 'message' => 'getted data'] , 200);
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
