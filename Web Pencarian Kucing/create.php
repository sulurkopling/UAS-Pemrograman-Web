<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data kucing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
            color: #555;
        }
        input[type="text"],
        input[type="file"],
        input[type="submit"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            border: none;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Tambah data kehilangan kucing</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="owner_name">Nama Pemilik:</label>
        <input type="text" id="owner_name" name="owner_name" required>

        <label for="cat_name">Nama Kucing:</label>
        <input type="text" id="cat_name" name="cat_name" required>

        <label for="address">Alamat:</label>
        <input type="text" id="address" name="address" required>

        <label for="phone">Nomor Telepon:</label>
        <input type="text" id="phone" name="phone" required>

        <label for="photo">Foto:</label>
        <input type="file" id="photo" name="photo" required>

        <input type="submit" value="Submit">
    </form>

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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $owner_name = $_POST['owner_name'];
        $cat_name = $_POST['cat_name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $photo = $_FILES['photo']['name'];

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO cats (owner_name, cat_name, address, phone, photo) VALUES ('$owner_name', '$cat_name', '$address', '$phone', '$photo')";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='message success'>Data baru berhasil dibuat. <a href='list.php'>Data kucing hilang</a></div>";
            } else {
                echo "<div class='message error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
            }
        } else {
            echo "<div class='message error'>Sorry, there was an error uploading your file.</div>";
        }
    }

    $conn->close();
    ?>
</div>

</body>
</html>
