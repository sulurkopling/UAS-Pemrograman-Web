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

$sql = "SELECT id, owner_name, cat_name, address, phone, photo FROM cats";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kucing Hilang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
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
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 800px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .cat-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            overflow: hidden;
        }
        .cat-item img {
            width: 150px;
            height: auto;
            border-radius: 5px;
            margin-right: 10px;
            float: left;
        }
        .cat-details {
            float: left;
            width: calc(100% - 170px); 
        }
        .cat-details h2 {
            margin-top: 0;
        }
        .cat-details p {
            margin-bottom: 5px;
        }
        .cat-details a {
            text-decoration: none;
            color: #4CAF50;
        }
        .cat-details a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Kucing Hilang</h1>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='cat-item'>";
                echo "<img src='uploads/" . $row["photo"]. "' alt='Cat Photo'>";
                echo "<div class='cat-details'>";
                echo "<h2>Nama Pemilik: " . $row["owner_name"]. "</h2>";
                echo "<p>Nama Kucing: " . $row["cat_name"]. "</p>";
                echo "<p>Alamat: " . $row["address"]. "</p>";
                echo "<p>No Telepon: " . $row["phone"]. "</p>";
                echo "<a href='edit.php?id=" . $row["id"] . "'>Edit</a> | <a href='delete.php?id=" . $row["id"] . "'>Delete</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No cats found.</p>";
        }
        $conn->close();
        ?>
        <a href="index.html">Tambah Daftar Kucing Hilang</a>
    </div>
</body>
</html>
