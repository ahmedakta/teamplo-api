<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema as FacadesSchema;

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
       $search_param = $request->get('search');
       // the array should have a labels and data
       $projectModel = new Project;
       $tableName = $projectModel->getTable();
       $columns = FacadesSchema::getColumnListing($tableName);
       $fields = [];
       foreach ($columns as $key => $column) {
           $field = [];
           $column == 'id' ? $field['isUnique'] = true : '';
           $field['field'] = $column;
           $field['title'] = ucwords(str_replace('_', ' ', $column));
           $field['width'] = "190px";
           array_push($fields , $field);
       }
       $data['cols'] = json_encode($fields);
       $projects = Project::where('project_name','LIKE', '%' . $search_param . '%')->paginate();
       $data['data'] = $projects;
       return response()->json($data);
    }
}
