<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome to Admin Dashboard</h1>
    <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <a href="logout.php">Logout</a>

    <!-- Include services and certificates management sections -->
    <section id="services">
        <h2>Manage Services</h2>
        <!-- Include code for displaying and managing services -->
    </section>

    <section id="certificates">
        <h2>Manage Certificates</h2>
        <!-- Include code for displaying and managing certificates -->
    </section>
</body>
</html>
