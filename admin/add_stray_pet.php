<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stray Pet</title>
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #f4f4f4;
            float: left;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        h2 {
            margin-top: 0;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="date"],
        input[type="email"],
        textarea,
        select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="sidebar">
    <?php include('C:/xampp/htdocs/bc/glbl/admin_sidebar.php');?>
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
    $intake_date = date('Y-m-d');
    $finder_name = $_POST['finder_name'];
    $pet_name = $_POST['pet_name'];
    $pet_details = $_POST['pet_details'];
    $address = $_POST['address'];
    $pet_type = $_POST['pet_type'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Pet photo handling
    if(isset($_FILES['pet_photo']['tmp_name'])) {
        $pet_photo = $_FILES['pet_photo']['tmp_name'];

        if ($pet_photo) {
            // Read pet photo file content
            $pet_photo_content = file_get_contents($pet_photo);
        } else {
            echo "ERROR: Pet photo is missing.";
        }
    } else {
        echo "ERROR: Pet photo not uploaded.";
    }

    // Valid ID photo handling
    if(isset($_FILES['valid_id_photo']['tmp_name'])) {
        $valid_id_photo = $_FILES['valid_id_photo']['tmp_name'];

        if ($valid_id_photo) {
            // Read valid ID photo file content
            $valid_id_photo_content = file_get_contents($valid_id_photo);
        } else {
            echo "ERROR: Valid ID photo is missing.";
        }
    } else {
        echo "ERROR: Valid ID photo not uploaded.";
    }

    // Prepare SQL statement
    $sql = "INSERT INTO stray_pets (intake_date, finder_name, pet_name, pet_details, pet_photo, address, pet_type, email, phone, valid_id_photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("ssssssssss", $intake_date, $finder_name, $pet_name, $pet_details, $pet_photo_content, $address, $pet_type, $email, $phone, $valid_id_photo_content);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            echo "Form submitted successfully!";
        } else {
            echo "ERROR: Could not execute query: $sql. " . $stmt->error;
        }
    } else {
        echo "ERROR: Could not prepare statement: $sql. " . $conn->error;
    }
}

?>
<div class="content">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" class="form">
    <h2>REPORT STRAY PET</h2>

    <label for="finder_name">Finder Name:</label>
    <input type="text" name="finder_name" required>

    <label for="pet_name">Pet Name:</label>
    <input type="text" name="pet_name" required>

    <label for="pet_details">Pet Details:</label>
    <textarea name="pet_details" required></textarea>

    <label for="address">Address:</label>
    <input type="text" name="address" required>

    <label for="pet_type">Pet Type:</label>
    <select name="pet_type" id="pet_type_select" required>
        <option value="Dog">Dog</option>
        <option value="Cat">Cat</option>
        <option value="Bird">Bird</option>
        <option value="Hen">Hen</option>
        <option value="Rabbit">Rabbit</option>
        <option value="Other">Other</option>
    </select>

    <!-- Add contact information fields to the form -->
    <label for="email">Email:</label>
    <input type="email" name="email" required>

    <label for="phone">Phone Number:</label>
    <input type="tel" name="phone" required>

    <label for="pet_photo">Pet Photo:</label>
    <input type="file" name="pet_photo" required>

    <label for="valid_id_photo">Valid ID Photo:</label>
    <input type="file" name="valid_id_photo" required>

    <input type="submit" value="Submit">
</form>
</div>
</body>
</html>
