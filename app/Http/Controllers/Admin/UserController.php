<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IApiUserRepository as ApiUserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(ApiUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $data = $this->userRepository->all();

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'user_name' => 'required',
            'full_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $input = $request->only([
            'user_name',
            'full_name',
            'email',
            'password',
            'role',
        ]);

        $data = $this->userRepository->create($input);

        return response()->json($data);
    }
}
