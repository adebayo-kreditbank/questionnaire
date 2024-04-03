<?php

namespace App\Repositories\Admin;

use App\Interfaces\Repository\Admin\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{

    public function getAll()
    {
        return User::all();
    }

    public function getById(int $id)
    {
        return User::findOrFail($id);
    }

    public function delete(int $id)
    {
        return User::destroy($id);
    }

    public function create(array $questionDetails)
    {
        return User::create($questionDetails);
    }

    public function update($id, array $newDetails)
    {
        return User::whereId($id)->update($newDetails);
    }

    public function getByAdminEmail(string $email)
    {
        return User::whereEmail($email)->where('role_id', '>', 0)->first();
    }
}
