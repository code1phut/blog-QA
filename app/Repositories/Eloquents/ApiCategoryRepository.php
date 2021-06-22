<?php


namespace App\Repositories\Eloquents;

use App\Models\Category;
use App\Repositories\Interfaces\IApiCategoryRepository;

class ApiCategoryRepository extends BaseRepository implements IApiCategoryRepository
{
    public function __construct()
    {
        $this->model = new Category();
    }
}
