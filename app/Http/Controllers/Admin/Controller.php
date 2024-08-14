<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;

abstract class Controller
{
    protected function hello()
    {
        return 1;
    }
    protected function getDepartmentProgressData()
    {
        // Get all departments with their progress
        $departments = Department::all()->map(function($department) {
            return [
                'name' => $department->department_name,
                'progress' => $department->progress()
            ];
        });

        // Calculate the total progress
        $totalProgress = $departments->sum('progress');

        // Compute percentage of each department's progress relative to the total progress
        $departments = $departments->map(function($department) use ($totalProgress) {
            return [
                'name' => $department['name'],
                'progress' => $totalProgress > 0 ? ($department['progress'] / $totalProgress) * 100 : 0
            ];
        });
       
        $labels = $departments->pluck('name')->toArray();
        $data = $departments->pluck('progress')->toArray();

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

}
