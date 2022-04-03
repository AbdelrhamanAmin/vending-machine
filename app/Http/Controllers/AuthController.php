<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{



    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required','unique:users,username'],
            'password' => ['required'],
            'role'     => ['required',Rule::in(USER::USER_ROLES)]
        ]);

        if($validator->fails()){
            return $this->handleError($validator->errors(), 'Validation Error', 400);
        }

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
        $data['token'] =  $user->createToken('auth_token')->plainTextToken;
        $data['username'] =  $user->username;
        return $this->handleResponse($data, ' registered!');
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            $auth = Auth::user();
            $success['token'] =  $auth->createToken('auth_token')->plainTextToken;
            $success['name'] =  $auth->name;

            return $this->handleResponse($success, 'User successfully logged-in');
        }
        else{
            return $this->handleError('Unauthorized.', ['error'=>'Unauthorized']);
        }
    }


    /**
     * Log the user out
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function logout()
    {
        return $this->handleResponse( auth()->user()->tokens()->delete(), 'User successfully logged-out');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function me()
    {
        return $this->handleResponse( auth()->user());
    }
}
