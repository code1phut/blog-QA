<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Eloquents\ApiCategoryRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{

    protected $categoryRepository;

    public function __construct(ApiCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $data = $this->categoryRepository->all();

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
            'name' => 'required',
            'icon_image' => 'required',
        ]);

        $input = $request->only([
            'name',
            'icon_image'
        ]);

        $data = $this->categoryRepository->create($input);

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'icon_image' => 'required',
        ]);
        $input = $request->only([
            'name',
            'icon_image',
        ]);

        $data = $this->categoryRepository->update($category, $input);
        return response()->json($data);
    }

    /**
     * @param Category $category
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(Category $category): JsonResponse
    {
        $data = $this->categoryRepository->destroy($category);

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return string
     * @throws ValidationException
     */
    public function upload(Request $request): string
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpg,jpeg,png',
        ]);

        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads/images'), $picName);

        return $picName;
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function deleteImage(Request $request)
    {
        $fileName = $request->get('image');
        $this->deleteFileFromServer($fileName);

        return response('', Response::HTTP_OK);
    }

    public function deleteFileFromServer($fileName)
    {
        $path = public_path().'/uploads/images/'.$fileName;
        if (file_exists($path)) {
            @unlink($path);
        }

        return;
    }
}
