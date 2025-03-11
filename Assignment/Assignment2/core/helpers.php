<?php

// Get the path to a given $filename
if (!function_exists('image')) {
    function image(string $filename): string
    {
        return "/images/$filename";
    }
}

// Return data from the session
if (!function_exists('getSessionData')) {
    function getSessionData(string $key)
    {
        return $_SESSION[$key] ?? null;
    }
}

// Return data and remove it from the session
if (!function_exists('popSessionData')) {
    function popSessionData(string $key)
    {
        $data = $_SESSION[$key] ?? null;
        unset($_SESSION[$key]);
        return $data;
    }
}

// Return old session data once in a form when an error occurs.
if (!function_exists('old')) {
    function old(string $key)
    {
        $data = $_SESSION[$key] ?? null;
        unset($_SESSION[$key]);
        return $data;
    }
}
