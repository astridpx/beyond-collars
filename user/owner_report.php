<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/bc/img/main_icon.png">
    <link rel="stylesheet" href="/bc/css/found_form.css">
    <title>Release Request Form</title>
</head>
<body style="background-image: url('/bc/img/smoke.png');">
    <?php include 'C:/xampp/htdocs/bc/glbl/navbar.php'; ?>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pet_id'])) {
        // Check if the form fields are set before accessing them
        if(isset($_POST['requester_name']) && isset($_POST['requester_contact']) && isset($_POST['release_reason']) && isset($_FILES['valid_id_photo']['tmp_name']) && isset($_FILES['past_photo']['tmp_name'])) {
            
            $pet_id = $_POST['pet_id'];
            $requester_name = $_POST['requester_name'];
            $requester_contact = $_POST['requester_contact'];
            $release_reason = $_POST['release_reason'];

            // Connect to your database (replace these variables with your actual database credentials)
            $servername = "localhost";
            $username = "root";
            $password = ""; // No password for root user
            $dbname = "bcdb";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and execute the query to insert release request
            $sql = "INSERT INTO release_requests (pet_id, requester_name, requester_contact, release_reason, valid_id_photo, past_photo) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssbb", $pet_id, $requester_name, $requester_contact, $release_reason, $valid_id_photo_data, $past_photo_data);

            // Upload and bind the photo data only if files were uploaded
            $valid_id_photo_data = isset($_FILES['valid_id_photo']['tmp_name']) ? file_get_contents($_FILES['valid_id_photo']['tmp_name']) : null;
            $past_photo_data = isset($_FILES['past_photo']['tmp_name']) ? file_get_contents($_FILES['past_photo']['tmp_name']) : null;

            if ($stmt->execute()) {
                echo "<h2>Release Request Submitted Successfully</h2>";
                echo "<p>Thank you for your request. It will be processed shortly.</p>";
            } else {
                echo "Error submitting release request: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        } 
    } else {
        echo "Invalid request";
    }
    ?>

    <div class="found-form-container">
        <form action="" method="post" enctype="multipart/form-data" class="found-form">
            <h2>Release Request Form</h2>
            <input type="hidden" name="pet_id" value="<?php echo htmlspecialchars($_POST['pet_id'] ?? ''); ?>">

            <label for="requester_name">Your Name:</label>
            <input type="text" name="requester_name" id="requester_name" required><br>

            <label for="requester_contact">Your Contact:</label>
            <input type="text" name="requester_contact" id="requester_contact" required><br>

            <label for="release_reason">Reason for Release:</label>
            <textarea name="release_reason" id="release_reason" required></textarea><br>

            <label for="past_photo">Past Photo with Pet:</label>
            <input type="file" name="past_photo" id="past_photo" accept="image/jpeg" required><br>

            <label for="valid_id_photo">Valid ID Photo:</label>
            <input type="file" name="valid_id_photo" id="valid_id_photo" accept="image/jpeg" required><br>

            <input type="submit" value="Submit Release Request">
        </form>
    </div>

    <?php include 'C:/xampp/htdocs/bc/glbl/footer.php';?>
</body>
</html>
