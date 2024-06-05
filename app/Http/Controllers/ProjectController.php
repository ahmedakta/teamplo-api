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
    //  preparting data for vue-data table.
    //    get the table columns
       $columns = FacadesSchema::getColumnListing($tableName);
    //    loop in columns to add a column value (department_id ex) to value title (Department ex)
       $fields = [];
       foreach ($columns as $key => $column) {
           $field = [];
           $column == 'id' ? $field['isUnique'] = true : '';
           $field['field'] = $column;
           $field['title'] = ucwords(str_replace('_', ' ', $column));
           $field['width'] = "190px";
           array_push($fields , $field);
       }
    //    add actions column manually
        array_push($fields , ['field' => 'actions' , 'title' => 'Actions' ]);
        
       $data['cols'] = json_encode($fields);
       $projects = Project::where('project_name','LIKE', '%' . $search_param . '%')->paginate();
       $data['data'] = $projects;
       return response()->json($data);
    }

    public function destroy($id)
    {
        $record = Project::find($id);
        if ($record) {
            $record->delete();
            return response()->json(['message' => 'Record deleted successfully'], 200);
        }

        return response()->json(['message' => 'Record not found'], 404);
    }

    public function view($id)
    {
        $data = Project::find($id);
        return response()->json($data);
    }
}
