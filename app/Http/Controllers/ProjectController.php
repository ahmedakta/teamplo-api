<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Helpers\Helper;
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
    public function index(Request $request)
    {
        // get params
        $search_param = $request->get('search');

        // prepare fields of model to datatable
        $fields = Helper::dataTable('Project');
        
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
}
