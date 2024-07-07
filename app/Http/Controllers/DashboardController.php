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
            $departments = Department::with('projects')->get();
            //  ____ Chart information data ____
            // Calculating logic : 
            // - we have projects belongs to department , we gonna plus all the tasks of all the projects of the department , and calculate the progress.
            $chartData = [];
            foreach ($departments as $key => $department) {
                $totalCompletedTasks = 0;
                $totalTasks = 0;
                if($department->projects)
                {
                    foreach ($department->projects as $key => $project) {
                        $totalTasks = $project->tasks->count();
                        foreach ($project->tasks as $task) {
                            if ($task->status == 1) {
                                $totalCompletedTasks++;
                            }
                        }
                    }
                }
                // Calculate department progress
                $progressValue = $totalTasks > 0 ? $totalCompletedTasks / $totalTasks : 0.0;
                array_push($chartData ,  $progressValue);
            }
            $data['chart'] = [
                'labels' =>$departments->pluck('department_name')->toArray(),
                'datasets' => [
                    [
                        'backgroundColor' => ['#41B883', '#6FB0C1', '#00D8FF', '#DD1B16' , '#4464C5'],
                        'data' => [1,2,3,4,5,6,7,8,9,10],
                    ]
                ]
            ];
            // [1,2,3,4,5,6,7,8,9,10]
            // Recent mentoined tasks

    
    
            // Projects progress section
            $projects = Project::with('users')->get();
            $data['projects'] = $projects;
            foreach ($projects as $key => $project) {
                if($project->tasks()->count())
                {
                    $project->progress = ($project->tasks()->where('status' , 1)->count() / $project->tasks()->count())  * 100;
                }
            }
        }
        return response()->json(['data' => $data , 'message' => 'success'] ,200);
    }
}
