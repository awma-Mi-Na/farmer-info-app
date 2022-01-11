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
            if (!Auth::attempt($validated)) {
                return response()->json(['message' => 'login failed'], 401);
            }

            return response()->json([
                'token' => request()->user()->createToken('auth_token')->plainTextToken,
            ], 201);
        } catch (\Exception $e) {
            response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
