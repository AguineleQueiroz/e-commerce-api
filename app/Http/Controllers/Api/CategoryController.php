<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    /**
     *
     * @param Category $repository
     */
    public function __construct(protected Category $repository){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->repository->paginate();
        if(!$categories) {
            return response()->json(['message' => 'The category list is empty.'], 404);
        }
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateCategoryRequest $request)
    {
        $data_new_category = $request->validated();
        $newCategory = $this->repository->create($data_new_category);
        return (new CategoryResource($newCategory))->response()->json(['message' => 'Category was created successfuly.'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->repository->findOrFail($id);
        if(!$category) {
            return response()->json(['message' => 'Category is not found.'], 404);
        }
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateCategoryRequest $request, string $id)
    {
        $new_data_category = $request->validated();
        $category = $this->repository->findOrFail($id);
        if(!$category) {
            return response()->json(['message' => 'Category is not found.'], 404);
        }
        $category->update($new_data_category);
        return (new CategoryResource($category))->response()->json(['message' => 'Category was updated successfuly.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->repository->findOrFail($id);
        if(!$category) {
            return response()->json(['message' => 'Category is not found.'], 404);
        }
        $category->delete();
        return response()->json(["message" => "Category was removed successfuly."]);
    }
}
