<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    // index view
    public function index($request)
    {
         // get search params
         $search_params = [
            ['seo_keywords', 'LIKE', '%' . $request->get('search') . '%'],
            ['content_title', 'LIKE', '%' . $request->get('search') . '%'],
            ['category_id', $request->get('department_id')],
            ['user_id', $request->get('project_start_at')],
            ['parent_id',14],
        ];
        // Filter out null values
        $search_params = array_filter($search_params, function($param) {
            return !is_null($param[1]);
        });
        
        // selected fields
        $data_table_columns = ['id' , 'user_id' , 'category_id' , 'content_title','content_body','slug', 'status'  , 'created_at' , 'updated_at'];
        
        $contents = Content::where($search_params)
        ->with([
            'category:id,category_name,category_color',
            'user:id,name',
        ])
        ->select($data_table_columns)
        ->orderBy('created_at', 'desc')  // First order by created_at in descending order
        ->paginate();

        // set data
        $data['data'] = $contents;
        return response()->json(['data' => $data , 'message' => 'getted data'] , 200);
    }

    public function page($page = null, $subPage = null, $subSubPage = null)
    {
        $typesIds = ['blogs' => 15];
        // get search params
        $search_params = [
            ['type_id', $typesIds[$page]],
        ];
          
        // Filter out null values
        $search_params = array_filter($search_params, function($param) {
            return !is_null($param[1]);
        });

        // selected fields
        $data_table_columns = ['id' , 'user_id' , 'category_id','content_image' , 'slug' , 'content_title','content_body','slug', 'status'  , 'created_at' , 'updated_at'];
        $contents = Content::where($search_params)
        ->with([
            'category:id,category_name,category_color',
            'user:id,name',
        ])
        ->select($data_table_columns)
        ->orderBy('created_at', 'desc')  // First order by created_at in descending order
        ->paginate();

        // set data
        $data['data'] = $contents;
        return response()->json(['data' => $data , 'message' => 'getted data'] , 200);
    }

    public function blogs()
    {
        return $this->page('blogs', null , null );
    }

    public function view($slug)
    {
        $data = Content::where('slug', $slug)->with('user')->first();
        return response()->json(['data' => $data , 'message' => 'success' ] , 200);
    }

    public function destroy($slug)
    {
        try{
            $content = Content::where('slug' , $slug)->first();
            if(!is_null($content))
            {
                $content->delete();
                $data = [];
                return response()->json(['data' => $data , 'message' => 'deleted successfully'] , 200);
            }
        }catch(\Exception $error){
            return response()->json(['error' => $error->getMessage()] , 400);
        }
    }
    
}
