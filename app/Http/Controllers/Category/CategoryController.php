<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\CategoryService;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryFormRequest;
use App\Http\Requests\EventFormRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $per_page = request()->query('per_page') ? request()->query('per_page') : 10;

        $result = $category->simplePaginate($per_page);

        $result->data = CategoryResource::collection($result);

        return response()->json($result);
    }

    public function show(Category $category)
    {
        return response()->json(new CategoryResource($category));
    }

    public function store(CategoryFormRequest $request, CategoryService $service)
    {
        return DB::transaction(function () use ($request, $service){
            $result = $service->make($request);
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event created successfully',
                    'data'    => $result
                ], Response::HTTP_CREATED);
            }

            return response()->json([
                'success' => false,
                'message' => 'Event creation failed'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Category $category,
        CategoryFormRequest $request,
        CategoryService $service
    )
    {
        return DB::transaction(function () use ($category, $request, $service) {
            if (empty($request->validated())) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category updated successfully'
                ], Response::HTTP_OK);
            }

            $result = $service->make($request, $category);
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category updated successfully',
                ], Response::HTTP_OK);
            }

            return response()->json([
                'success' => false,
                'message' => 'Category update failed'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
