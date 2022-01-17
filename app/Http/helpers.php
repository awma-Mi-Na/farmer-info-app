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
