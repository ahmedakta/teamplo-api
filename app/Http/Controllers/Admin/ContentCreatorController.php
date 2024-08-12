<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Category;

class ContentCreatorController extends Controller
{
    public function index()
    {
        // pages and categories count KPI'S      
        $data['content_count'] =  Content::count(); 
        $data['category_count'] =  Category::count(); 
        return response()->json(['data' => $data , 'message' => 'success'] ,200);
    }
}
