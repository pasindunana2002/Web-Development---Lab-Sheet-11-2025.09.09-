<?php
$conn = new mysqli("localhost", "root", "", "authdb");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($pass) >= 8) {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashed);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Registration successful! <a href='login.php'>Login here</a></p>";
        } else {
            echo "<p style='color:red;'>Email already exists.</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color:red;'>Invalid input. Password must be at least 8 chars.</p>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<body>
<h2>Register</h2>
<form method="post">
  Name: <input type="text" name="name"><br><br>
  Email: <input type="text" name="email"><br><br>
  Password: <input type="password" name="password"><br><br>
  <input type="submit" value="Register">
</form>
</body>
</html>
