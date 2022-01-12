<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Validator;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Create auth token and store in db if login attempt is successful.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        return attempt_login($validator->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the login token from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // if ($request->user()->currentAccessToken()->delete())
        //     return response()->json(['message' => 'logout successful.']);

        try {
            $request->user()->currentAccessToken()->delete();
            Auth::logout();
            return response()->json(['message' => 'Logout successful.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
