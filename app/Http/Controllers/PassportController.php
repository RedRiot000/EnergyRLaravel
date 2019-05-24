<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PassportController extends BaseController
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = new User($request->all());

        //encrypting the password
        $user['password']  = bcrypt($request->password);

        $user->save();

        $token = $user->createToken('Energyr')->accessToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'message' => 'use this token to access data'
        ]);
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {

            $token = auth()->user()->createToken('energyr')->accessToken;
            return $this->sendResponse($token, "Successfully Logged In");
        } else {
            return $this->sendResponse("Unauthorized access", "");
        }
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        auth()->user()->payments;
        return response()->json([
            'status' => 200,
            'message' => 'data retrieved successfully',
            'user' => auth()->user()
        ]);
    }

}
