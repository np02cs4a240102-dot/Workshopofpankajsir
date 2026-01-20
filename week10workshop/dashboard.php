<?php
require 'session.php';
require 'db.php';

// Logout handler
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

$userEmail = '';

if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare(
        "SELECT email FROM users WHERE id = :id"
    );
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $user = $stmt->fetch();

    if ($user) {
        $userEmail = $user['email'];
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>

<h1>Dashboard</h1>

<?php if ($userEmail): ?>
    <p>Logged in as: <?= htmlspecialchars($userEmail) ?></p>

    <form method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
<?php else: ?>
    <a href="login.php">
        <button>Login</button>
    </a>
<?php endif; ?>

</body>
</html>
