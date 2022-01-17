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
                if (Auth::user()->role == 'agent')
                    $token = Auth::user()->createToken('auth_token')->plainTextToken;
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
