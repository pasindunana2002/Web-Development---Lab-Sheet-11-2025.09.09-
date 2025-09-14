<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<body>
<h2>Welcome, <?php echo $_SESSION['user']; ?>!</h2>
<a href="logout.php">Logout</a>
</body>
</html>
