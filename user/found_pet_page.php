<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/bc/img/main_icon.png">
    <link rel="stylesheet" href="/bc/css/found_form.css">
    <title>Add more info</title>
</head>

<body style="background-image: url('/bc/img/smoke.png');">
    <?php include 'C:/xampp/htdocs/bc/glbl/navbar.php'; ?>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pet_id'])) {
        // Handle the form submission logic
        $found_pet_id = $_POST['pet_id'];

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

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['found_name']) && isset($_POST['found_details']) && isset($_FILES['found_photo']) && isset($_FILES['valid_id_photo']) && isset($_POST['termsCheckbox'])) {
            $found_name = $_POST['found_name'];
            $found_details = $_POST['found_details'];
            $found_photo_data = file_get_contents($_FILES['found_photo']['tmp_name']);
            $valid_id_photo_data = file_get_contents($_FILES['valid_id_photo']['tmp_name']);

            // Insert data into the 'found_pets' table
            $insert_sql = "INSERT INTO found_pets (pet_id, found_name, found_details, found_photo, valid_id_photo) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            // Set the status as 0 (not resolved) when inserting data
            $status = 0;
            $stmt->bind_param("issss", $found_pet_id, $found_name, $found_details, $found_photo_data, $valid_id_photo_data, $status);

            if ($stmt->execute()) {
                // Display success message or redirect to another page
                echo "<h2>Thank you for reporting! Details for Pet ID: $found_pet_id</h2>";
                echo "<p>Name: $found_name</p>";
                echo "<p>Details: $found_details</p>";
                echo "<p>Status: Not Resolved</p>";
                echo "<p><strong>Found Pet Photo:</strong> <img src='data:image/jpeg;base64," . base64_encode($found_photo_data) . "' alt='Found Pet Photo' style='max-width: 300px;'></p>";
                echo "<p><strong>Valid ID Photo:</strong> <img src='data:image/jpeg;base64," . base64_encode($valid_id_photo_data) . "' alt='Valid ID Photo' style='max-width: 300px;'></p>";
            } else {
                echo "Error storing found pet details: " . $stmt->error;
            }

            $stmt->close();
        } else {
            // Display the form to gather additional details
            echo '<form action="/bc/user/found_pet_page.php" method="post" enctype="multipart/form-data" class="found-form">';
            echo "<h2>REPORT FORM</h2>";
            echo '<input type="hidden" name="pet_id" value="' . $found_pet_id . '">';

            // Other form fields
            echo '<label for="found_name">Name:</label>';
            echo '<input type="text" name="found_name" id="found_name" required><br>';

            echo '<label for="found_details">Details:</label>';
            echo '<textarea name="found_details" id="found_details" required></textarea><br>';

            echo '<label for="found_photo">Pet Photo:</label>';
            echo '<input type="file" name="found_photo" id="found_photo" accept="image/jpeg" required><br>';

            echo '<label for="valid_id_photo">Valid ID Photo:</label>';
            echo '<input type="file" name="valid_id_photo" id="valid_id_photo" accept="image/jpeg" required><br>';

            // Terms and Policy Checkbox
            echo '<label id="termsCheckboxLabel" for="termsCheckbox">';
            echo '<input type="checkbox" id="termsCheckbox" name="termsCheckbox" required>';
            echo 'I have read and agree to the <a href="/bc/glbl/link_to_terms_of_use.html" target="_blank">Terms</a> and <a href="/bc/glbl/link_to_privacy_policy.html" target="_blank">Privacy Policy</a>.';
            echo '</label>';

            echo '<input type="submit" value="SUBMIT DETAILS">';
            echo '</form>';
        }

        $conn->close();
    } else {
        echo "Invalid request";
    }
    ?>

    <?php include 'C:/xampp/htdocs/bc/glbl/footer.php'; ?>
</body>

</html>