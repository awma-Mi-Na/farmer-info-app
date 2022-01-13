<?php
if (!function_exists('getErrorMessages')) {
    function getErrorMessages($messageArrays)
    {
        $errorMessages = [];
        foreach ($messageArrays as $messageArrayItems) {
            foreach ($messageArrayItems as $message) {
                array_push($errorMessages, $message);
            }
        }
        return $errorMessages;
    }
}

if (!function_exists('attempt_login')) {
    function attempt_login($validated)
    {
        try {
            if (Auth::attempt($validated)) {
                // return 'authenticated';
                return response()->json([
                    // 'token' => request()->user()->createToken('auth_token')->plainTextToken,
                    'user' => Auth::user()
                ], 200);
            }
            // request()->session()->regenerate();

            // return 'unauthenticated';

            return response()->json(['message' => 'login failed'], 401);
        } catch (\Exception $e) {
            response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
