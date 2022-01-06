<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

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
        $attributes = $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ]);
        if (!Auth::attempt($attributes)) {
            return response('login failed');
        }

        return $request->user()->createToken('auth_token')->plainTextToken;
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
            return response()->json(['message' => 'logout successful.']);
        } catch (\Exception $e) {
            return $e;
        }
    }
}
