<?php
namespace App\Repositories;
use App\Models\User;

class UserRepository{

    public function create(array $data): void{
        (new User($data))->save();
    }

    public function userExists(string $parameter, string $value): User|null{
       return User::where($parameter,$value)->first();
    }

}