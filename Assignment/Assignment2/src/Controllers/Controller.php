<?php

namespace src\Controllers;

class Controller
{
    /**
     * @param string $view The view to render (without the .php extension!)
     * @param array $data
     * @return void
     */
    protected function render(string $view, array $data = []): void
    {
        // import variables from the $data array to the current symbol table
        // making them accessible to the $view.
        extract($data);
        include __DIR__ . '/../../views/' . $view . '.view.php';
        exit;
    }

    /**
     * @param string $to
     * @param bool $exit
     * @return void
     */
    protected function redirect(string $to, bool $exit = true): void
    {
        header("Location: $to");
        if ($exit) {
            exit;
        }
    }

    public function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public static function setSessionData(string $key, array|string $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function getSessionData(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function destroySession(): bool
    {
        return session_destroy();
    }

}
