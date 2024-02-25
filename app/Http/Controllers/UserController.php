<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Event;

class UserController extends Controller
{
    private $service;
    public function __construct(){
        $this->service = new UserService;
    }
    public function store(UserRequest $request){
        try {
            if($this->service->userExists('email',$request->email)){
                return response()->json(['message'=>'Email already exist'],400);
            }
    
            $data = $request->validated();
    
            $this->service->create($data);

            Event::dispatch(new UserCreated($data));

            return response()->json(['message'=>'User created successfully'],200);
    
        } catch (\Exception $e) {
            info('User creation error',[$e]);
            return response()->json(['message'=>'Error creating user'],500);
        }
    }
}
