<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cat_directory";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $owner_name = $_POST['owner_name'];
    $cat_name = $_POST['cat_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $current_photo = $_POST['current_photo'];
    $photo = $current_photo;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            // Allow certain file formats
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                    $photo = basename($_FILES["photo"]["name"]);
                    // Optionally, delete old photo if it exists
                    if ($current_photo && file_exists($target_dir . $current_photo)) {
                        unlink($target_dir . $current_photo);
                    }
                } else {
                    $message = "Sorry, there was an error uploading your file.";
                    $messageType = "error";
                }
            } else {
                $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
                $messageType = "error";
            }
        } else {
            $message = "File is not an image.";
            $messageType = "error";
        }
    }

    if (empty($message)) {
        $sql = "UPDATE cats SET owner_name='$owner_name', cat_name='$cat_name', address='$address', phone='$phone', photo='$photo' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            $message = "Data berhasil diperbarui.";
            $messageType = "success";
        } else {
            $message = "Error updating record: " . $conn->error;
            $messageType = "error";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data Kucing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .message {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 4px;
            color: white;
        }
        .message.success {
            background-color: #28a745;
        }
        .message.error {
            background-color: #dc3545;
        }
        a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Update Data Kucing</h1>
    <?php if ($message): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo $message; ?> <a href='list.php'>Lihat Data Kucing</a>
        </div>
    <?php else: ?>
        <p>Data telah diperbarui. <a href='list.php'>Kembali ke Data Kucing</a></p>
    <?php endif; ?>
</div>

</body>
</html>
