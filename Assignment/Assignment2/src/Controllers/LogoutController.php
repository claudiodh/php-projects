<?php

namespace src\Controllers;

class LogoutController extends Controller
{
    /**
     * Log out the user by destroying the session and redirecting to the homepage.
     *
     * @return void
     */
    public function logout(): void
    {
        // Ensure session is started
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Clear all session data
        $_SESSION = [];

        // Delete the session cookie if it exists
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy the session.
        session_destroy();

        // Redirect to the home page for unauthenticated users
        $this->redirect('/');
    }
}