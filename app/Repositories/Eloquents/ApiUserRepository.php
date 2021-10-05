<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Interfaces\IApiUserRepository;

class ApiUserRepository extends BaseRepository implements IApiUserRepository
{
    public function __construct()
    {
        $this->model = new User();
    }

    public function createUser($request) {
        return User::create([
            'user_name' => $request['user_name'],
            'full_name' => $request['full_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role' => $request['role'],
        ]);
    }

    public function updateUser($request, $user) {
        return User::find($user->id)->update([
            'user_name' => $request['user_name'],
            'full_name' => $request['full_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role' => $request['role'],
        ]);
    }
}
