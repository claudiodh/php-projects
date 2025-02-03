<?php
session_start();

// Ensure only guest users can access this page.
if (isset($_SESSION['email']) && substr($_SESSION['email'], -8) === '@bcit.ca') {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['email'])) {
        $_SESSION['errors']['email'] = 'An email is required.';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors']['email'] = 'Please enter a valid email address.';
    }

    if (empty($_POST['password'])) {
        $_SESSION['errors']['password'] = 'A password is required.';
    }

    if (!empty($_SESSION['errors'])) {
        $_SESSION['attempted_email'] = $_POST['email'];
        header('Location: login.php');
        exit;
    }

    // Check if the submitted email ends with '@bcit.ca'
    if (substr($_POST['email'], -8) === '@bcit.ca') {
        $_SESSION['email'] = $_POST['email']; // Use email as authentication flag.
        header('Location: dashboard.php');
        exit;
    } else {
        $_SESSION['errors']['email'] = 'You must use a bcit.ca email address.';
        $_SESSION['attempted_email'] = $_POST['email'];
        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
<div class="w-full max-w-md p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-center text-2xl font-bold text-gray-900">Sign in to your account</h2>
    <p class="text-center text-sm text-gray-600">
        Don’t have an account? <a href="register.php" class="text-indigo-600 hover:text-indigo-500">Register</a>
    </p>

    <form action="login.php" method="post" class="mt-6">
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <input id="email" name="email" type="text" autocomplete="email"
                   value="<?php echo isset($_SESSION['attempted_email']) ? htmlspecialchars($_SESSION['attempted_email']) : ''; ?>"
                   class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <?php if (isset($_SESSION['errors']['email'])): ?>
                <p class="text-red-500 text-sm"><?php echo $_SESSION['errors']['email']; unset($_SESSION['errors']['email']); ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password"
                   class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <?php if (isset($_SESSION['errors']['password'])): ?>
                <p class="text-red-500 text-sm"><?php echo $_SESSION['errors']['password']; unset($_SESSION['errors']['password']); ?></p>
            <?php endif; ?>
        </div>

        <div class="flex items-center justify-between">
            <a href="forgot_password.php" class="text-sm text-indigo-600 hover:text-indigo-500">Forgot your password?</a>
        </div>

        <button type="submit"
                class="w-full mt-4 py-2 px-4 bg-indigo-600 text-white font-medium rounded-lg shadow-md hover:bg-indigo-700">
            Sign in
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm font-medium text-gray-700">Or continue with</p>
        <div class="mt-2 flex justify-center space-x-4">
            <button class="p-2 border rounded-lg">
                <img src="https://cdn.jsdelivr.net/npm/simple-icons@v6/icons/facebook.svg" class="w-5 h-5" alt="Facebook">
            </button>
            <button class="p-2 border rounded-lg">
                <img src="https://cdn.jsdelivr.net/npm/simple-icons@v6/icons/twitter.svg" class="w-5 h-5" alt="Twitter">
            </button>
            <button class="p-2 border rounded-lg">
                <img src="https://cdn.jsdelivr.net/npm/simple-icons@v6/icons/github.svg" class="w-5 h-5" alt="GitHub">
            </button>
        </div>
    </div>
</div>
</body>
</html>