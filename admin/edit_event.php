<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 14px; /* Smaller font size */
        }
        .container {
            margin-left: 250px; /* Width of sidebar */
            padding: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
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
            max-width: 100px;
            max-height: 100px;
        }
        .upload-label {
            margin-top: 5px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <?php include('C:/xampp/htdocs/bc/glbl/admin_sidebar.php');?>
    </div>

    <div class="container">
        <h2>Edit Event</h2>
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

            if(isset($_GET['id'])) {
                $event_id = $_GET['id'];
                
                // Fetch event details from the database
                $sql = "SELECT title, when_datetime, description, picture FROM news_event WHERE id = $event_id";
                $result = $conn->query($sql);

                if ($result === FALSE) {
                    echo "Error fetching event details: " . $conn->error;
                } elseif ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    // Display edit form
                    echo "<form method='post' enctype='multipart/form-data'>";
                    echo "<input type='hidden' name='event_id' value='$event_id'>";
                    echo "<label for='title'>Title:</label>";
                    echo "<input type='text' id='title' name='title' value='" . $row['title'] . "' required>";

                    echo "<label for='when_datetime'>Date and Time:</label>";
                    // Format the datetime value
                    $formatted_datetime = date("Y-m-d\TH:i", strtotime($row['when_datetime']));
                    echo "<input type='datetime-local' id='when_datetime' name='when_datetime' value='" . $formatted_datetime . "' required>";

                    echo "<label for='description'>Description:</label>";
                    echo "<textarea id='description' name='description' required>" . $row['description'] . "</textarea>";

                    echo "<label for='picture'>Picture:</label>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($row['picture']) . "'/><br>";
                    echo "<input type='file' id='picture' name='picture' accept='image/*'>";
                    echo "<label class='upload-label' for='picture'></label>";

                    echo "<input type='submit' name='submit' value='Submit'>";
                    echo "</form>";
                } else {
                    echo "Event not found.";
                }
            } else {
                echo "Event ID not provided.";
            }

            // Close connection
            $conn->close();
        ?>

<?php
    // Database connection for updating event
    if(isset($_POST['submit'])) {
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

        // Collect form data
        $event_id = $_POST['event_id'];
        $title = $_POST['title'];
        $when_datetime = $_POST['when_datetime'];
        $description = $_POST['description'];

        // Escape variables to prevent SQL injection
        $title = $conn->real_escape_string($title);
        $when_datetime = $conn->real_escape_string($when_datetime);
        $description = $conn->real_escape_string($description);

        // Update event in the database
        $sql = "UPDATE news_event SET title='$title', when_datetime='$when_datetime', description='$description'";

        // Check if a new picture is uploaded
        if ($_FILES['picture']['size'] > 0) {
            $picture = $_FILES['picture']['tmp_name'];
            // Read image file content
            $pictureContent = file_get_contents($picture);
            // Append the picture update to the SQL query
            $sql .= ", picture='" . $conn->real_escape_string($pictureContent) . "'";
        }

        $sql .= " WHERE id=$event_id";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Event updated successfully.')</script>";
            echo "<script>window.location.href = '/bc/admin/admin_event.php';</script>";
        } else {
            echo "Error updating event: " . $conn->error;
        }

        // Close connection
        $conn->close();
    }
?>
    </div>
</body>
</html>
