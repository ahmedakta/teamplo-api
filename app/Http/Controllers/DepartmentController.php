<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Task;

class DepartmentController extends Controller
{
    public function index()
    {
        // Get All Active Departments
        $data['departments'] = Department::all();
        return response()->json(['data' => $data , 'message' => 'success'] ,200);
    }

    public function view($slug)
    {
        $data['department'] = Department::where('slug', $slug)->first();
        $data['tasks'] = Task::where('project_id' , 1)->get();
        return response()->json(['data' => $data , 'message' => 'success' ] , 200);
    }
}
