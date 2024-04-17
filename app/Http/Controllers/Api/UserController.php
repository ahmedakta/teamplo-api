<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UsersCollection;

class UserController extends Controller
{
    public function loggedInUser()
    {
        try{
            $user = User::where('id' , auth()->user()->id)->get();
            // TODO , we should return : new UsersCollection($user) collection instead of object.
            return response()->json($user->toArray() , 200);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()] , 400);
        }
    }
}
