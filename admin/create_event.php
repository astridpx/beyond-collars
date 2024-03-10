<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #f4f4f4;
            float: left;
        }
        .container {
            margin-left: 250px; /* Width of sidebar */
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
        }
        input[type="text"],
        input[type="datetime-local"],
        textarea,
        input[type="file"] {
            width: calc(100% - 16px); /* Width of container minus padding */
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        img {
            max-width: calc(100% - 16px); /* Width of container minus padding */
            height: auto;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <?php include('C:/xampp/htdocs/bc/glbl/admin_sidebar.php');?>
    </div>

    <div class="container">
        <h2>Quick Event Form</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            
            <label for="when_datetime">Date and Time:</label>
            <input type="datetime-local" id="when_datetime" name="when_datetime" required>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            
            <label for="picture">Picture:</label>
            <input type="file" id="picture" name="picture" accept="image/*" required>
            
            <input type="submit" value="Submit">
        </form>
    </div>

    <?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "bcdb";

// Attempt MySQL server connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("ERROR: Could not connect. " . $conn->connect_error);
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $title = $_POST['title'];
    $when_datetime = $_POST['when_datetime'];
    $description = $_POST['description'];

    // Image handling
    $picture = $_FILES['picture']['tmp_name'];
    if ($picture) {
        // Read image file content
        $pictureContent = file_get_contents($picture);

        // Prepare SQL statement
        $sql = "INSERT INTO news_event (title, when_datetime, description, picture) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $null = NULL;
            $stmt->bind_param("sssb", $title, $when_datetime, $description, $null);
            $stmt->send_long_data(3, $pictureContent);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                echo "<p>Records inserted successfully.</p>";
            } else {
                echo "ERROR: Could not execute query: $sql. " . $stmt->error;
            }
        } else {
            echo "ERROR: Could not prepare statement: $sql. " . $conn->error;
        }
    } else {
        echo "ERROR: No picture uploaded.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>


</body>
</html>
