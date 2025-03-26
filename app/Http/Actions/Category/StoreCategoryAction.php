<?php

namespace App\Http\Actions\Category;

use App\Models\Category;

class StoreCategoryAction
{
    public function __invoke(array $payload)
    {
        return Category::create($payload);
    }
}
