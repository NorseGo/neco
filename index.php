<?php
include 'config.php';
session_start();

$photos = [];
$sql = "SELECT * FROM photos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $photos[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Photo Gallery</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="upload.php">Upload New Photo</a>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>

    <div class="gallery">
        <?php foreach ($photos as $photo): ?>
            <div class="photo" onclick="openModal('<?php echo $photo['image_path']; ?>')">
                <img src="<?php echo $photo['image_path']; ?>" alt="Photo">
            </div>
        <?php endforeach; ?>
    </div>

    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-content">
            <img id="modalImage" src="">
        </div>
    </div>

    <script>
        function openModal(imageSrc) {
            document.getElementById("myModal").style.display = "flex";
            document.getElementById("modalImage").src = imageSrc;
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
            document.getElementById("modalImage").src = "";
        }
    </script>
</body>
</html>
