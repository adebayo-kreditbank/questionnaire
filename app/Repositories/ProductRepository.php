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
    public function getAll(bool $descOrder = false)
    {
        return $descOrder ? Product::orderBy('id', 'DESC')->get(): Product::all();
    }

    /**
     * retrieve a product by ID
     * @return Product
     */
    public function getById(int $productId): Product
    {
        return Product::with('category')->findOrFail($productId);
    }

    public function delete(int $productId)
    {
        return Product::destroy($productId);
    }

    public function create(array $productDetails)
    {
        return Product::create($productDetails);
    }

    public function update($productId, array $newDetails)
    {
        return Product::whereId($productId)->update($newDetails);
    }

    public function getAllByCategoryId(int $categoryId): Collection
    {
        return Product::with('category')->whereCategoryId($categoryId)->get();
    }
}
