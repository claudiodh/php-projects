<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome!</title>
</head>
<body>
<h1>Welcome!</h1>

<?php
session_start();
if (isset($_SESSION['email']) && substr($_SESSION['email'], -8) === '@bcit.ca') {
    // Authenticated user view.
    echo "<p>Welcome, " . htmlspecialchars($_SESSION['email']) . "!</p>";
    echo '<p><a href="dashboard.php">Go to your dashboard</a></p>';
    echo '<p><a href="logout.php">Logout</a></p>';
} else {
    // Guest user view.
    echo "<p>Please log your credentials.</p>";
    echo '<p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>';
}
?>

</body>
</html>
