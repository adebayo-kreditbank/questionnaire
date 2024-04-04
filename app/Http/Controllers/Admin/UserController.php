<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\Role;
use App\Repositories\Admin\UserRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ResponseTrait;


    /**
     * Inject relevant repository dependencies
     * use repository in case data layer needs to change
     */
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    /**
     * Admin Login
     * COULD BE DONE DIFFERENTLY. NOT SO IMPORTANT IN THIS PROJECT,
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = $this->userRepository->getByAdminEmail($credentials['email']);

        if (Auth::attempt($credentials)) {

            $token = $user->createToken($credentials['email']);

            return $this->onSuccess(
                statusCode: Response::HTTP_OK,
                data: [
                    'name' => $user->full_name,
                    'token' => $token->plainTextToken
                ]
            );
        }

        return $this->onError(statusCode: Response::HTTP_BAD_REQUEST);
    }
}
