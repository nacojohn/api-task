<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        //request for all post values
        $input = $request->all();

        //Validate to ensure valid inputs
        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //handle validation error
        if ($validator->fails())
            return $this->sendError('Validation error', $validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);

        if (Auth::once(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();
            $token = $user->createToken('login-token');

            return $this->sendResponse([
                'token' => $token->plainTextToken
            ], 'Logged in successfully');
        }
 
        return $this->sendError('Invalid Login', '', Response::HTTP_UNAUTHORIZED);
    }
}
