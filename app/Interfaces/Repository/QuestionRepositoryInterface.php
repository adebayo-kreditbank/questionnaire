<?php
namespace App\Interfaces\Repository;

interface QuestionRepositoryInterface 
{
    public function getAll();
    public function getAllById(int $questionId);
    public function delete(int $questionId);
    public function create(array $questionDetails);
    public function update($questionId, array $newDetails);
}