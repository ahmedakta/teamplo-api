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

    public function page($page = '/', $subPage = null, $subSubPage = null)
    {
        // _________________ Always we have main page ex 'blogs' and contents 'blogs' belongs to this page _____________
        $typesIds = ['blogs' => 15 , 'content' => 16];

        // ______ get search params ______

        $search_params = [
            ['status', 1],
        ];  

        //  - ________ Filter out null values ______
        $search_params = array_filter($search_params, function($param) {
            return !is_null($param[1]);
        });

        // ______ get selected columns ______
        $columns = ['id' , 'user_id' , 'category_id','content_image' ,'content_body','content_title','slug','created_at'];


        // _____ get main page _______
        $content = Content::where('slug', $page)->with('user')->first();


        // ______ get children pages ______
        $contents = $content->children()
        ->select($columns)
        ->where($search_params)
        ->orderBy('created_at', 'desc')  // First order by created_at in descending order
        ->paginate();

        // - ______ loop in pages to set reading time _____ 
        foreach ($contents as $key => $content) {
        $wordsPerMinute = 200; // Average reading speed
        $wordCount = str_word_count(strip_tags($content->content_body)); // Count words in content
        $content->reading_time = ceil($wordCount / $wordsPerMinute);
        }


        // ____ set data ___
        $data['content'] = $content;
        $data['contents'] = $contents;
        return response()->json(['data' => $data , 'message' => 'getted data'] , 200);
    }

    public function blogs()
    {
        return $this->page('blogs', null , null );
    }

    public function view($slug)
    {
        $data = Content::where('slug', $slug)->with('user','children')->first();
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
