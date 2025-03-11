<?php
// Set secure session cookie parameters before starting the session
session_set_cookie_params([
    'lifetime' => 0,              // until browser is closed
    'path'     => '/',            // accessible throughout the domain
    'domain'   => '',             // current domain
    'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on', // only over HTTPS
    'httponly' => true,           // not accessible via JavaScript
    'samesite' => 'Lax'
]);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use core\Application as Application;

(new Application())->run();
