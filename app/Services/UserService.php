<?php
namespace App\Services;
use App\Repositories\UserRepository;

class UserService{

    private $repository;

    public function __construct(){
        $this->repository = new UserRepository;
    }

    public function create(array $data): void{
        $this->repository->create($data);
    }

    public function userExists($parameter,$value): bool{
       return $this->repository->userExists($parameter,$value) ? true : false;
    }

}