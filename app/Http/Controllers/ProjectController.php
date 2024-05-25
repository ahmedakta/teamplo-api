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
    public function index()
    {
       // the array should have a labels and data
       $projectModel = new Project;
       $tableName = $projectModel->getTable();
       $columns = FacadesSchema::getColumnListing($tableName);
       $fields = [];
       foreach ($columns as $key => $column) {
           $field = [];
           $field['field'] = $column;
           $field['title'] = ucwords(str_replace('_', ' ', $column));
           $field['width'] = "90px";
           array_push($fields , $field);
       }
       $data['cols'] = json_encode($fields);
       // { field: "id", title: "ID", width: "90px", filter: false },
       $projects = Project::paginate();
       $data['data'] = $projects->toJson();
       return response()->json($data);
    }
}
