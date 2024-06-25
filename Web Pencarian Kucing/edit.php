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

$id = $_GET['id'];

$sql = "SELECT * FROM cats WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $owner_name = $row['owner_name'];
    $cat_name = $row['cat_name'];
    $address = $row['address'];
    $phone = $row['phone'];
    $photo = $row['photo'];
} else {
    echo "0 results";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kucing</title>
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
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Data Kucing</h1>
    <form action="update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="current_photo" value="<?php echo $photo; ?>">
        <label for="owner_name">Nama Pemilik:</label>
        <input type="text" id="owner_name" name="owner_name" value="<?php echo $owner_name; ?>" required><br>

        <label for="cat_name">Nama Kucing:</label>
        <input type="text" id="cat_name" name="cat_name" value="<?php echo $cat_name; ?>" required><br>

        <label for="address">Alamat:</label>
        <input type="text" id="address" name="address" value="<?php echo $address; ?>" required><br>

        <label for="phone">No Telepon:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required><br>

        <label for="photo">Foto:</label>
        <input type="file" id="photo" name="photo"><br>
        <img src="uploads/<?php echo $photo; ?>" alt="Current Photo" style="max-width: 100px;"><br>

        <input type="submit" value="Update">
    </form>
</div>

</body>
</html>
