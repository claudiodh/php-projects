<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\UserRepository;

class RegistrationController extends Controller
{
    /**
     * Display the registration page.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request): void
    {
        $this->render('register', [
            'title' => 'User Registration',
        ]);
    }

    /**
     * Process the user registration form.
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request): void
    {
        // Make sure the session is started before we use $_SESSION
        $this->startSession();

        // Only proceed if the request is a POST
        if ($request->method() !== 'POST') {
            $this->redirect('/register');
        }

        // Collect registration data from the request
        $data = [
            'name'     => htmlspecialchars(trim($request->input('name') ?? ''), ENT_QUOTES, 'UTF-8'),
            'email'    => htmlspecialchars(trim($request->input('email') ?? ''), ENT_QUOTES, 'UTF-8'),
            'password' => $request->input('password') ?? ''
        ];

        $userRepository = new UserRepository();

        // Check if the email is already used
        if ($userRepository->getByEmail($data['email'])) {
            $_SESSION['flash'] = "Email is already in use.";
            $this->redirect('/register');
        }

        // Validate registration data
        $errors = $userRepository->validateRegistration($data);
        if (!empty($errors)) {
            $_SESSION['flash'] = implode(" ", $errors);
            $this->redirect('/register');
        }

        // Save the user to the database
        $user = $userRepository->saveUser(
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT, ["cost" => 12])
        );

        // If save fails, display an error and redirect
        if (!$user) {
            $_SESSION['flash'] = "An error occurred while registering. Please try again.";
            $this->redirect('/register');
        }

        // Store user data in the session
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['flash'] = "Registration successful!";
        $this->redirect('/');
    }
}