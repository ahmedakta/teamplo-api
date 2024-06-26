<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Project;
use App\Models\User;
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
    public function index(Request $request)
    {
        // get params
        $search_param = $request->get('search');
        // selected fields
        $data_table_columns = ['id' , 'department_id','slug', 'project_name'  , 'project_start_at' , 'project_end_at' , 'project_budget' , 'project_priority' ,'project_stage'];
        // prepare fields of model to datatable
        $fields = Helper::dataTable('Project' , $data_table_columns);
        $data['cols'] = json_encode($fields);
        $projects = Project::where('project_name', 'LIKE', '%' . $search_param . '%')
        ->with([
            'priority:id,category_name,category_color',
            'stage:id,category_name,category_color',
            'department:id,department_name',
            'users'
        ])
        ->select($data_table_columns)
        ->orderBy('created_at', 'desc')  // First order by created_at in descending order
        ->orderBy('project_priority', 'asc')  // Then order by priority_id in ascending order
        ->paginate();        // Get Progress of projects
        foreach ($projects as $key => $project) {
            if($project->tasks()->count())
            {
                $project->progress = ($project->tasks()->where('status' , 1)->count() / $project->tasks()->count())  * 100;
            }
        }
        $data['data'] = $projects;
        return response()->json(['data' => $data , 'message' => 'getted data'] , 200);
    }

    public function destroy($id)
    {
        $record = Project::find($id);
        if ($record) {
            $record->delete();
            return response()->json(['message' => 'Record deleted successfully' , 'data' => []], 200);
        }

        return response()->json(['message' => 'Record not found' , 'data' => []], 404);
    }

    public function view($slug)
    {
        $data = Project::where('slug', $slug)->first();
        return response()->json(['data' => $data , 'message' => 'success' ] , 200);
    }

    public function update(Request $request)
    {
        try{
            $data = $request->all()['params'];
            unset($data['id']);
            $record = Project::findOrFail($request->all()['params']['id']);
            $record->update($data);
            $msg = 'Record Updated Successfully';
            $code = 200;
        }catch(\Exception $e){
            $msg = $e->getMessage();
            $code = 500;
        }
        return response()->json(['message' => $msg], $code);
        // return
    }

    public function save(Request $request)
    {
        try{
            $data = $request->all()['params']['value'];
            $project = Project::create($data);
            $msg = "Project Created Successfully";
            $code = 200;
        }catch(\Exception $e){
            $msg = $e->getMessage();
            $code = 500;
        }
        return response()->json(['message' => $msg], $code);
    }

    public function create()
    {
        $departments = $this->currentUser->company->departments->where('status' , 1);
        $data['stages'] = Category::where('parent_id' , 1)->get();
        $data['departments'] = $departments;
        return response()->json(['data' => $data ,'message' => 'sucess'], 200);
    }

    public function users($department_id)
    {
        $assignmentUsers = Department::find($department_id)->users;
        $data['assignmentUsers'] = $assignmentUsers;
        return response()->json(['data' => $data , 'message' => 'success'] , 200);
    }

    public function userAssignment(Request $request)
    {
        $params = $request->all()['params'];
        // Find the project
        $project = Project::findOrFail($params['project_id']);

   
        // Check if the user is already assigned to the project
        if ($project->users()->where('user_id', $params['user_id'])->exists()) {
            // Detach the user from the project
            $project->users()->detach($params['user_id']);
            return response()->json([
                'data' => [],
                'message' => 'User is detached from this project',
            ], 200);
        }

        // Attach the user to the project
        $project->users()->attach($params['user_id']);
        $data = [];
        $data['project_users'] = $project->load('users');
        return response()->json(['data' => $data , 'message' => 'User Assigned Successfully'] , 200);
    }
}
