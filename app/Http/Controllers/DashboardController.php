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
        $data = [];
        // ADMIN ROLE DATA
        if($this->currentUser->role_id == User::ADMIN_ROLE)
        {
            // ____ Load Models ___ 
            $departments = Department::all();
            //  ____ Chart information data ____
            $data['chart'] = [
                'labels' =>$departments->pluck('department_name')->toArray(),
                'datasets' => [
                    [
                        'backgroundColor' => ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
                        'data' => [20 , 30 ,50 ,40 ,10 ,5 ,70 ,80 , 90 , 40],
                    ]
                ]
            ];
            // Recent mentoined tasks

    
    
            // Projects progress section
            $projects = Project::all();
            $data['projects'] = $projects;
        }
        return response()->json($data);
    }
}
