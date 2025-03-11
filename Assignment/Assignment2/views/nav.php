<?php
// Ensure a session is started so we have access to $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Retrieve authenticated user info from the session
$authenticatedUser = $_SESSION['user_id'] ?? null;

// Retrieve the user's name from the active session; if it's not set, then we leave it empty
$fullName = $_SESSION['user_name'] ?? '';
$firstName = $fullName ? explode(' ', trim($fullName))[0] : '';

// Build the avatar URL with a cache-busting query parameter if set,
// otherwise fallback to the default image.
$userAvatar = isset($_SESSION['user_avatar'])
    ? '/images/' . $_SESSION['user_avatar'] . '?v=' . time()
    : '/images/default.jpg';
?>

<div class="navbar bg-indigo-500 text-primary-content">
    <div class="flex-1">
        <a class="btn btn-ghost normal-case text-xl" href="/">NewCo.</a>
    </div>

    <li class="flex-none">
        <ul class="menu menu-horizontal px-1">
            <?php if ($authenticatedUser): ?>
                <!-- Link to the 'settings' page -->
                <a href="/articles/create" class="text-white px-3 py-2 rounded-md text-sm font-medium">New Article</a>
                <div class="flex items-center space-x-4 px-3">
                    <a href="/settings" class="flex items-center space-x-2">
                        <img src="<?= htmlspecialchars($userAvatar, ENT_QUOTES, 'UTF-8'); ?>"
                             alt="User Avatar" class="w-10 h-10 rounded-full object-cover">
                        <span class="text-white font-medium">
                            Welcome, <?= htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8'); ?>!
                        </span>
                    </a>
                    <a href="/logout" class="ml-20">
                        <img src="images/logout.png" alt="Logout" class="w-5 h-5">
                    </a>
                </div>
            <?php else: ?>
                <!-- Guest -->
                <div class="flex float-right">
                    <a href="/login" class="text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    <a href="/register" class="text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
                </div>
            <?php endif; ?>
        </ul>
    </li>
</div>