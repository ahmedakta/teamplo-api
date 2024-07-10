<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->currentUser = Auth::user();
    }
    public function index()
    {
        // Get All Active Departments
        $departments = $this->currentUser->company->departments->where('status' , 1)->select(['id', 'slug', 'department_name','department_desc']);
        $data['departments'] =$departments;
        return response()->json(['data' => $data , 'message' => 'success'] ,200);
    }

    public function view($slug)
    {
        $data['department'] = Department::where('slug', $slug)->first();
        $data['tasks'] = Task::where('project_id' , 1)->get();
        return response()->json(['data' => $data , 'message' => 'success' ] , 200);
    }
}
