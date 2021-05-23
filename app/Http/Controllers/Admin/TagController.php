<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Repositories\Interfaces\IApiTagRepository as ApiTagRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagRepository;

    public function __construct(ApiTagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $data = $this->tagRepository->all();

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $input = $request->only([
            'name'
        ]);

        $data = $this->tagRepository->create($input);

        return response()->json($data);
    }


    /**
     * @param Request $request
     * @param Tag $tag
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Tag $tag): JsonResponse
    {
        $this->validate($request, [
           'name' => 'required',
        ]);
        $input = $request->only([
           'name',
        ]);

        $data = $this->tagRepository->update($tag, $input);
        return response()->json($data);
    }

    /**
     * @param $tag
     * @return JsonResponse
     */
    public function delete(Tag $tag): JsonResponse
    {
        $data = $this->tagRepository->destroy($tag);

        return response()->json($data);
    }
}
