<?php
namespace App\Helpers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema as FacadesSchema;
class Helper
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    // This function preparing the passed model data to datatable library
    public static function dataTable(string $modelName , array $selected_columns)
    {
        // Resolve the model instance dynamically
        $modelInstance = app('App\\Models\\' . $modelName);
        $model = new $modelInstance;
        $tableName = $model->getTable();
        $columns = FacadesSchema::getColumnListing($tableName);
         //    loop in columns to add a column value (department_id ex) to value title (Department ex)
        $fields = [];
        foreach ($columns as $key => $column) {
            if(in_array($column , $selected_columns))
            {
                $field = [];
                $column == 'id' ? $field['isUnique'] = true : '';
                $field['field'] = $column;
                $field['title'] = ucwords(str_replace('_', ' ', $column));
                $field['width'] = $column == 'id' ? "75px" : "150px";
                array_push($fields , $field);
            }
        }

        // Projects Table
        if($modelName == 'Project')
        {
            // Add Fields
            array_push($fields , ['width' => '100px','field' => 'progress' , 'title' => 'Progress' ]);
            array_push($fields , ['field' => 'assignments' , 'title' => 'Assignments' , 'width' => '100px' ]);
        }

        //    add actions column manually
        array_push($fields , ['field' => 'actions' , 'title' => 'Actions' , 'width' => '10px']);

        return $fields;
    } 

    public static function sendEmail($data)
    {
        try{
            Mail::to('teamplocom@gmail.com')->send(new ContactMail($data));
            $msg = 'Email Function Runned Successfully';
            $code = 200;
        }catch(\Exception $e){
            $msg = $e->getMessage();
            $code = 500;
        }
        return response()->json(['data' => [] , 'message' => $msg] , $code);
    }
}
?>