<?php

namespace App\Http\Services;

use App\Http\Actions\Category\StoreCategoryAction;
use App\Http\Actions\Category\UpdateCategoryAction;
use App\Http\Requests\CategoryFormRequest;
use App\Models\Category;

class CategoryService
{
    public function __construct(
        public StoreCategoryAction $store_action,
        public UpdateCategoryAction $update_action
    ){}

    public function make(CategoryFormRequest $request, ?Category $category = null)
    {
        return $request->isMethod('POST')
            ? ($this->store_action)($request->validated())
            : ($this->update_action)($category, $request->validated());
    }
}
