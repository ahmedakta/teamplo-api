<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $currentUser;

    public function __construct()
    {
        $this->currentUser = Auth::user();

        // You can share more data here if needed
    }
    // Dashboard index view for all roles
    public function index()
    {
        // ADMIN ROLE DATA
        $data = [];
        if($this->currentUser->role_id == User::ADMIN_ROLE)
        {
            //  ____ Chart information data ____
            $projects = Project::all();
            $departments = Department::all();
            $data['chart']['labels'] = $departments->pluck('department_name')->toArray();
            $data['chart']['data'] = [20 , 30 ,50 ,40 ,10 ,5 ,70 ,80 , 90 , 40];
            
            // Recent mentoined tasks
    
    
            // Projects progress section
            return response()->json($data);
        }
    }
}
