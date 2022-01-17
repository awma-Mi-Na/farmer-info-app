<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'messages' => getErrorMessages($validator->messages()->getMessages())
            ], 422);
        }

        try {
            if (Auth::attempt($validator->validated())) {
                // if (Auth::user()->role == 'agent')
                // $token = Auth::user()->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'user' => Auth::user(),
                    'token' => $token ?? null
                ], 200);
            }
            return response()->json(['message' => 'login failed'], 401);
        } catch (\Exception $e) {
            response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
