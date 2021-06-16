<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
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
