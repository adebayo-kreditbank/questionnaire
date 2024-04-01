<?php
namespace App\Interfaces\Repository;

use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface extends RepositoryInterface
{
    # extends declarations from the parent Interface before this

    public function getAllByCategoryId(int $categoryId): Collection;
}