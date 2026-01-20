<?php
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!$email) {
        $message = 'Invalid email format.';
    } elseif (strlen($password) < 6) {
        $message = 'Password must be at least 6 characters.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            "INSERT INTO users (email, password) VALUES (:email, :password)"
        );

        $stmt->execute([
            ':email' => $email,
            ':password' => $hash
        ]);

        $message = 'Signup successful. Redirecting...';
        header('refresh:2;url=login.php');
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Signup</title></head>
<body>

<h2>Signup</h2>

<p><?= htmlspecialchars($message) ?></p>

<form method="POST">
    <label>Email</label><br>
    <input type="text" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Signup</button>
</form>

<br>
<a href="login.php">⬅ Back to Login</a>

</body>
</html>
