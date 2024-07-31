<?php

namespace App\Services\CRUD;

use App\Repositories\CRUD\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function getAllCategory(): Collection
    {
        return $this->categoryRepository->getCategory();
    }
}
