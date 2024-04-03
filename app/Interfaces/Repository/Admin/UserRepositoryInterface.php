<?php
namespace App\Interfaces\Repository\Admin;

use App\Interfaces\Repository\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getByAdminEmail(string $email);
}