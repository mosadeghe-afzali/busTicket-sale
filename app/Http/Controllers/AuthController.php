<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as HTTPResponse;
use Illuminate\Support\Facades\Validator;
use App\repositories\UserRoleRepository;
use App\Http\Controllers\Controller;
use App\repositories\RoleRepository;
use App\repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Exceptions\Response;


class AuthController extends Controller
{
    use Response;

    public $userRepository;
    public $roleRepository;
    public $userRoleRepository;

    // injection of UserRepository, RoleRepository and RoleUserRepository dependencies to this class:
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository, UserRoleRepository $userRoleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->userRoleRepository = $userRoleRepository;
    }

    // register of a new user and set its role in database
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->getErrors($validator->errors()->first(), HTTPResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data['password'] = Hash::make($request->password);

        DB::beginTransaction();

        $this->userRepository->store($data);
        $this->roleRepository->store();
        $this->userRoleRepository->store($this->userRepository, $this->roleRepository);

        DB::commit();

        return $this->getMessage(
            'کاربر با موفقیت ثبت شد',
            HTTPResponse::HTTP_OK
        );

    }

    // login users in site
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails())
        {
            return $this->getErrors($validator->errors()->first(), HTTPResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $this->userRepository->checkUser($request->email);
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('userToken')->accessToken;
                return response()->json([
                    'token' => $token,
                    'token_type' => 'bearer',
                    'code' => 200
                ]);
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



