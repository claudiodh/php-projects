<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\UserRepository;
use PDO;

class LoginController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct()
    {
        // Create the PDO connection with the provided credentials
        $pdo = new PDO(
            'mysql:host=localhost;dbname=article_aggregator_co;charset=utf8mb4',
            'root',
            'totodile',
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );

        // Instantiate the UserRepository using this connection
        $this->userRepository = new UserRepository($pdo);
    }

    /**
     * Displays the login view if the user is not logged in,
     * otherwise redirects to the home page.
     */
    public function index(Request $request): void
    {
        // If the user is already logged in, redirect them
        if (!$request->isGuest()) {
            $this->redirect('/');
            return;
        }

        // Otherwise, render the login view
        $this->render('login');
    }

    /**
     * Processes the login form submission.
     */
    public function login(Request $request): void
    {
        // Get email and password from $_POST
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Check if either field is empty
        if (empty($email) || empty($password)) {
            $_SESSION['flash'] = 'Please enter your email and password.';
            $this->redirect('/login');
            return;
        }

        // Attempt to retrieve the user by email
        $user = $this->userRepository->getByEmail($email);
        if (!$user) {
            error_log('No user found with email: ' . $email);
            $_SESSION['flash'] = 'The provided credentials do not match our records.';
            $this->redirect('/login');
            return;
        }

        // Verify the provided password against the hash in the DB
        $storedHash = $user->getPasswordDigest();
        if (!password_verify($password, $storedHash)) {
            error_log(' Invalid password attempt for user: ' . $email);
            $_SESSION['flash'] = 'The provided credentials do not match our records.';
            $this->redirect('/login');
            return;
        }

        // Successful login: store user data in the session
        $_SESSION['user_id']    = $user->getId();
        $_SESSION['user_name']  = $user->getName();
        $_SESSION['user_email'] = $user->getEmail();
        $_SESSION['user_avatar'] = $user->getProfilePicture();

        // Prevent session fixation
        session_regenerate_id(true);

        error_log('User logged in successfully: ' . $email);

        // Redirect to the originally intended page, if exists
        if (isset($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            $this->redirect($redirect);
        } else {
            $this->redirect('/');
        }
    }
}