<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Project;

class CommentController extends Controller
{
    public function save(Request $request , $slug)
    {
        $project = Project::where('slug', $slug)->with('comments.user')->first();
        // firstly check the record by slug
        if (!$project) {
            return response()->json(['data' => NULL,'message' => 'Record Not found'],500);
        }
        // get input
        $comment_desc = $request->all()['params']['comment_desc'];
        if(!$comment_desc)
        {
            return response()->json(['data' => NULL,'message' => 'Comment cannot be null'],500);
        }
        // saving the comment
        try{
            $project->comments()->create([
                'user_id' => auth()->id(),
                'comment_desc' => $comment_desc,
            ]);

            $msg = "Comment Created Successfully";
            $code = 200;
        }catch(\Exception $e){
            $msg = $e->getMessage();
            $code = 500;
        }
        return response()->json(['data' => NULL,'message' => $msg], $code);
    }
}
