<?php
namespace App\Interfaces\Repository;

interface RepositoryInterface
{
    public function getAll(bool $descOrder = false);
    public function getById(int $id);
    public function delete(int $id);
    public function create(array $details);
    public function update($id, array $details);
}