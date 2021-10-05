<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            'user_name' => "required|unique:users,id,$request->id",
            'full_name' => 'required',
            'email' => 'bail|required|email|unique:users',
            'password' => 'min:6',
            'role' => 'required',
        ]);

        $input = $request->only([
            'user_name',
            'full_name',
            'email',
            'password',
            'role',
        ]);

        $data = $this->userRepository->createUser($input);

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $this->validate($request, [
            'user_name' => "required|unique:users,id,$request->id",
            'full_name' => 'required',
            'email' => "bail|required|email|unique:users,id,$request->id",
            'password' => 'bail|required|min:6',
            'role' => 'required',
        ]);

        $input = $request->only([
            'user_name',
            'full_name',
            'email',
            'password',
            'role',
        ]);

        $data = $this->userRepository->updateUser($input, $user);
        return response()->json($data);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function delete(User $user): JsonResponse
    {
        $data = $this->userRepository->destroy($user);

        return response()->json($data);
    }
}
