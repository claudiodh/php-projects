<?php
session_start();

// Only allow access if the user is authenticated.
if (!isset($_SESSION['email']) || substr($_SESSION['email'], -8) !== '@bcit.ca') {
    header('Location: login.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<h1>This is the dashboard page only for logged users.</h1>
<p>You're logged in as <?php echo htmlspecialchars($_SESSION['email']); ?></p>
<br>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
