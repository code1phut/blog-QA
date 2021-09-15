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
}
