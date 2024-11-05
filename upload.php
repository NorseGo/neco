<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["photo"])) {
    $userId = $_SESSION['user_id'];
    $targetDir = "uploads/";
    $fileName = basename($_FILES["photo"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
        $sql = "INSERT INTO photos (user_id, image_path) VALUES ('$userId', '$targetFilePath')";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
        } else {
            echo "<div class='error-message'>Database error.</div>";
        }
    } else {
        echo "<div class='error-message'>File upload error.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Upload Photo</title>
</head>
<body>
    <div class="upload-container">
        <form action="" method="POST" enctype="multipart/form-data" class="upload-form">
            <h2 class="upload-title">Upload Photo</h2>
            <label for="file-upload" class="custom-file-label">Choose a file</label>
            <input type="file" name="photo" id="file-upload" required class="file-input">
            <button type="submit" class="upload-button">Upload</button>
        </form>
    </div>
</body>
</html>

