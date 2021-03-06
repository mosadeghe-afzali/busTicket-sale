<?php

namespace App\Http\Controllers;

use App\Traits\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\repositories\RoleRepository;
use App\repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\repositories\UserRoleRepository;
use Illuminate\Http\Response as HTTPResponse;

class AuthController extends Controller
{
    use Response;

    public $userRepository;
    public $roleRepository;
    public $userRoleRepository;

    /**
     * Create a new user instance.
     *
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @param UserRoleRepository $userRoleRepository
     */
    public function __construct(UserRepository $userRepository,
                                RoleRepository $roleRepository,
                                UserRoleRepository $userRoleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->userRoleRepository = $userRoleRepository;
    }

    /**
     * register of a new user and set its role in database.
     *
     * @param \App\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $data =
            ['name' => $request->name,
             'email' => $request->email,
             'password' => $request->password,
             'gender' => $request->gender,
            ];

        $data['password'] = Hash::make($request->password);

        DB::beginTransaction();

        $user = $this->userRepository->store($data);
        $token = $user->createToken('userToken')->accessToken;
        $this->roleRepository->store();
        $this->userRoleRepository->store($this->userRepository, $this->roleRepository);

        DB::commit();

        return $this->getMessage(
            'کاربر با موفقیت ثبت شد',
            HTTPResponse::HTTP_OK,
            $token
        );
    }

    /**
     * login users in site
     *
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->checkUser($request->email);
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('userToken')->accessToken;
                return $this->getMessage(
                    'خوش آمدید',
                    HTTPResponse::HTTP_OK,
                    $token,
                );
            } else {
                return $this->getErrors(
                    'پسورد وارد شده اشتتباه است',
                    HTTPResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {
            return $this->getErrors(
                'ایمیل واردشده وجود ندارد',
                HTTPResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return $this->getErrors(
            'You have been successfully logged out!',
            HTTPResponse::HTTP_OK);
    }
}



