<?php
namespace App\Helpers;
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
                $field['width'] = "150px";
                array_push($fields , $field);
            }
        }
            //    add actions column manually
         array_push($fields , ['field' => 'actions' , 'title' => 'Actions' ]);
         return $fields;
    } 
}
?>