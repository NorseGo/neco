<?php
include 'config.php';
session_start();
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    if (empty($username) || empty($password)) {
        $message = 'Both fields are required.';
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                if ($remember) {
                    setcookie("user_id", $user['id'], time() + (86400 * 30), "/");
                }
                header("Location: index.php");
                exit();
            } else {
                $message = 'Incorrect password.';
            }
        } else {
            $message = 'User not found.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="login.php" method="POST">
        <h2>Login</h2>
        <div class="message"><?php echo $message; ?></div>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <label>
            <input type="checkbox" name="remember"> Remember Me
        </label>
        <button type="submit">Login</button>
    </form>
</body>
</html>

