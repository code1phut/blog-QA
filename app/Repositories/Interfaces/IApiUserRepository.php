<?php

namespace App\Repositories\Interfaces;

interface IApiUserRepository extends IBaseRepository
{
    public function createUser($request);
    public function updateUser($input, $user);
}
