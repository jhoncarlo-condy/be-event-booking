<?php

namespace App\Http\Actions\Category;

use App\Models\Category;

class UpdateCategoryAction
{
    public function __invoke(Category $category, array $payload)
    {
        return $category->update($payload);
    }
}
