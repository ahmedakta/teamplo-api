<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    protected $currentUser;

    public function __construct()
    {
        $this->currentUser = Auth::user();

        // You can share more data here if needed
    }
    public function index()
    {
        // the array should have a labels and data
        $projects = Project::all();
        $departments = Department::all();
        $data['labels'] = $departments->pluck('department_name')->toArray();
        $data['data'] = [20 , 30 ,50 ,40 ,10 ,5 ,70 ,80 , 90 , 40];
        return response()->json($data);
    }
}
