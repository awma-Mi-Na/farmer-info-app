<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::filter(request()->all())->paginate(request('per_page') ?? 20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => ['required', Rule::in(['agent', 'admin'])],
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|max:25',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'messages' => getErrorMessages($validator->messages()->getMessages())
            ], 422);
        }

        try {
            return response()->json(User::create($validator->validated()), 201);

            //? users are created by the admin only, login not required
            // return attempt_login($request->only(['email', 'password']));
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return response()->json(auth()->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => ['required_without_all:name,email,password', Rule::in(['agent', 'admin'])],
            'name' => 'required_without_all:role,email,password|max:255',
            'email' => ['required_without_all:role,name,password', 'email', Rule::unique('users', 'email')->ignore(auth()->user()->id)],
            'password' => 'required_without_all:role,name,email|min:5|max:25',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'messages' => getErrorMessages($validator->messages()->getMessages())
            ], 422);
        }
        try {
            Auth::user()->update($validator->validated());
            return response()->json([
                'message' => 'User details updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
