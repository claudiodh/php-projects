<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\UserRepository;

class SettingsController extends Controller
{
    /**
     * Display the settings (profile) page.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request): void
    {
        // Make sure the session is started
        $this->startSession();

        // If user is not logged in, redirect to the login page
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        // Instantiate the UserRepository to fetch current user info
        $userRepository = new UserRepository();
        $userId = (int) $_SESSION['user_id'];
        $user = $userRepository->getById($userId);

        // If no user found, redirect to login
        if (!$user) {
            $_SESSION['flash'] = "User not found.";
            $this->redirect('/login');
        }

        // Render the settings page, passing current user data.
        // The controller passes variables (userEmail, userName, profilePicture)
        // which the view uses directly.
        $this->render('settings', [
            'title'           => 'Settings',
            'userId'          => $user->getId(),
            'userEmail'       => $user->getEmail(),
            'userName'        => $user->getName(),
            'profilePicture'  => $user->getProfilePicture()
        ]);
    }

    /**
     * Process user profile updates (e.g., username, profile picture).
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request): void
    {
        // Ensure the session is active
        $this->startSession();

        // Only proceed if the request is POST
        if ($request->method() !== 'POST') {
            $this->redirect('/settings');
        }

        // If the user isn't logged in, redirect to login
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        // Instantiate UserRepository and get current user data
        $userRepository = new UserRepository();
        $userId = (int) $_SESSION['user_id'];
        $currentUser = $userRepository->getById($userId);
        if (!$currentUser) {
            $_SESSION['flash'] = "User not found.";
            $this->redirect('/login');
        }

        // Gather the form data (for example, 'username')
        $data = [
            'username' => htmlspecialchars(trim($request->input('username') ?? ''), ENT_QUOTES, 'UTF-8'),
        ];

        // Flag to detect any changes
        $isChanged = false;

        // Check if the username is different from the current one
        if ($data['username'] !== $currentUser->getName()) {
            $isChanged = true;
        }

        // Handle file upload for profile picture, if any
        $newProfilePicture = null;
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/images/';
            $filename  = basename($_FILES['profile_picture']['name']);
            $target    = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
                $newProfilePicture = $filename;
                if ($filename !== $currentUser->getProfilePicture()) {
                    $isChanged = true;
                }
            } else {
                $_SESSION['flash'] = "Error uploading file.";
                $this->redirect('/settings');
            }
        }

        // If nothing changed, prompt the user and do not proceed
        if (!$isChanged) {
            $_SESSION['flash'] = "Please change a value before saving.";
            $this->redirect('/settings');
        }

        // Use existing updateUser method from UserRepository
        $updateSuccess = $userRepository->updateUser($userId, $data['username'], $newProfilePicture);

        if ($updateSuccess) {
            $_SESSION['flash'] = "Your profile has been updated.";

            // Refresh user data from the database to update session variables
            $updatedUser = $userRepository->getById($userId);
            if ($updatedUser) {
                $_SESSION['user_name']   = $updatedUser->getName();
                $_SESSION['user_email']  = $updatedUser->getEmail();
                $_SESSION['user_avatar'] = $updatedUser->getProfilePicture();
            }
        } else {
            $_SESSION['flash'] = "Could not update your profile. Please try again.";
        }

        $this->redirect('/');
    }
}