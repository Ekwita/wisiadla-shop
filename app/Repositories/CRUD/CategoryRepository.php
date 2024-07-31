<?php

namespace App\Repositories\CRUD;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function getCategory(): Collection
    {
        return Category::all();
    }
}