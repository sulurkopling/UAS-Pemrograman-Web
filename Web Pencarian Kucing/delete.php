<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat Directory</title>
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
        }
        .message {
            font-size: 1.2em;
            margin-bottom: 20px;
        }
        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .error {
            color: #FF0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "cat_directory";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("<p class='error'>Connection failed: " . $conn->connect_error . "</p>");
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Get the photo file name to delete the file from the server
            $sql = "SELECT photo FROM cats WHERE id=$id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $photo = $row['photo'];
                unlink("uploads/$photo");
            }

            // Delete the record from the database
            $sql = "DELETE FROM cats WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                echo "<p class='message'>Data telah berhasil dihapus. <a href='list.php'>Lihat Data Kucing</a></p>";
            } else {
                echo "<p class='error'>Error deleting record: " . $conn->error . "</p>";
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
