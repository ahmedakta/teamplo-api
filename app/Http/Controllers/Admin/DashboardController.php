<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $currentUser;

    public function __construct()
    {
        $this->currentUser = Auth::user();
    }
    // Dashboard index view for all roles
    public function index(Request $request)
    {
        $data = [];
        // ADMIN ROLE DATA
        if($this->currentUser->role_id == User::ADMIN_ROLE)
        {
             // set vars
            $user = $this->currentUser;
            $company = $user->company;
            $companyUsers = $user->company->users;
            $companyDepartments = $company->departments()->with('projects')->get();
            $chartData['labels'] = [];
            $chartData['data'] = [];
            // ___ Get Chart settings ___
            $startAt = null;
            $endAt = null;
            $period = null;

            // ____ Load Data ___ 
            // ____ TASKS BY DEPARTMENT ___
            // $data['tasks'] = Project::first()->completedTasks();

            //  ____ DEPARTMENTS PROGRESS CHAT INFROMATION DATA ____


            // Calculating logic : 
            // - we have projects belongs to department , we gonna plus all the tasks of all the projects of the department , and calculate the progress.
            $chartData = $this->getDepartmentProgressData();

            $data['departments_progress']['chart'] = [
                'labels' => $chartData['labels'],
                'datasets' => [
                    [
                        'borderColor' => 'rgba(75, 192, 192, 1)',
                        'borderWidth' => 1,
                        'label' => 'Data',
                        'backgroundColor' => [
                            '#41B883', // 1
                            '#6FB0C1', // 2
                            '#00D8FF', // 3
                            '#DD1B16', // 4
                            '#4464C5', // 5
                            '#A3D977', // 6
                            '#FF8C42', // 7
                            '#8C4DFF', // 8
                            '#FF6358', // 9
                            '#2E8B57', // 10
                        ],
                        'data' => $chartData['data'],
                    ]
                ]
            ];
            // reset chart data
            $chartData['labels'] = [];
            $chartData['data'] = [];

            // _____ END OF DEPARTMENTS PROGRESS CHAT INFROMATION DATA
    

            // ___ COMPANY EMPLOYEES ___
            foreach ($companyDepartments as $key => $department) {
                    $chartData['labels'][] = $department->department_name;
                    $chartData['data'][] = $department->users->count();
            }
            $data['company_users']['chart'] = [
                'labels' => $chartData['labels'],
                'datasets' => [
                    [
                        'borderColor' => 'rgba(75, 192, 192, 1)',
                        'borderWidth' => 1,
                        'label' => 'Employee',
                        'backgroundColor' => [
                            '#41B883', 
                            '#6FB0C1', 
                            '#00D8FF', 
                            '#DD1B16', 
                            '#4464C5', 
                            '#A3D977', 
                            '#FF8C42', 
                            '#8C4DFF', 
                            '#FF6358', 
                            '#2E8B57',
                        ],
                        'data' => $chartData['data'],
                    ]
                ]
            ];

            // ___ END OF COMPANY EMPLOYEES ___
        }
        return response()->json(['data' => $data , 'message' => 'success'] ,200);
    }
}
