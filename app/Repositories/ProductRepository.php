<?php

namespace App\Repositories;

use App\Interfaces\Repository\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::all();
    }

    /**
     * retrieve a question by ID
     * @return Product
     */
    public function getById(int $questionId): Product
    {
        return Product::with('category')->findOrFail($questionId);
    }

    public function delete(int $questionId)
    {
        return Product::destroy($questionId);
    }

    public function create(array $questionDetails)
    {
        return Product::create($questionDetails);
    }

    public function update($questionId, array $newDetails)
    {
        return Product::whereId($questionId)->update($newDetails);
    }

    public function getAllByCategoryId(int $categoryId): Collection
    {
        return Product::with('category')->whereCategoryId($categoryId)->get();
    }
}
