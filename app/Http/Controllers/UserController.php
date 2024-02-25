<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function store(UserRequest $request){
        if(User::where('email',$request->email)){
            return response()->json(['message'=>'Email already exist'],400);
        }
       (new User($request->validated()))->save();
       
    }
}
