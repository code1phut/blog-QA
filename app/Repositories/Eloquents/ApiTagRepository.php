<?php


namespace App\Repositories\Eloquents;


use App\Models\Tag;
use App\Repositories\Interfaces\IApiTagRepository;


class ApiTagRepository extends BaseRepository implements IApiTagRepository
{
    public function __construct()
    {
        $this->model = new Tag();
    }
}
