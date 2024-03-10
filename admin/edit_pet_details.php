<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bcdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch specific record from the database based on ID
    $sql = "SELECT * FROM add_pet WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Insert the data into 'not_found_pets' table
        $sql_insert = "INSERT INTO not_found_pets (pet_name, lost_date, details, photo, pet_type) 
                        VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sssss", $row['pet_name'], $row['lost_date'], $row['pet_details'], $row['pet_photo'], $row['pet_type']);

        $stmt_insert->execute();

        echo "Data inserted into 'not_found_pets' table.";
    } else {
        echo "Record not found.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to update the record
    $id = $_POST['id'];
    $owner_name = $_POST['owner_name'];
    $pet_name = $_POST['pet_name'];
    $pet_type = $_POST['pet_type'];
    $pet_details = $_POST['pet_details'];
    $lost_date = $_POST['lost_date'];
    $address = $_POST['address'];
    // You need to handle image uploads separately if you're allowing users to update images.

    // Update the record in the database
    $sql = "UPDATE add_pet SET owner_name=?, pet_name=?, pet_type=?, pet_details=?, lost_date=?, address=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $owner_name, $pet_name, $pet_type, $pet_details, $lost_date, $address, $id);
    if ($stmt->execute()) {
        // Delete the record from the database
        $delete_sql = "DELETE FROM add_pet WHERE id=?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);
        $delete_stmt->execute();

        // Redirect to the specified page after successful update and deletion
        header("Location: /bc/admin/pending_lost_pet.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request";
    exit();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet Details</title>
    <style>
        .container {
            display: flex;
            justify-content: space-between;
        }
        .sidebar {
            float: left;
            width: 20%;
            height: 100%;
            background-color: #f2f2f2;
            padding: 20px;
        }
        .content {
            flex-basis: 80%;
            padding: 20px;
        }
        form {
            max-width: 500px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <?php include('C:/xampp/htdocs/bc/glbl/admin_sidebar.php');?>
        </div>
        <div class="content">
            <h1>Edit Pet Details</h1>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <label for="owner_name">Owner Name:</label>
                <input type="text" id="owner_name" name="owner_name" value="<?php echo $row['owner_name']; ?>">

                <label for="pet_name">Pet Name:</label>
                <input type="text" id="pet_name" name="pet_name" value="<?php echo $row['pet_name']; ?>">

                <label for="pet_type">Pet Type:</label>
                <input type="text" id="pet_type" name="pet_type" value="<?php echo $row['pet_type']; ?>">

                <label for="pet_details">Pet Details:</label>
                <textarea id="pet_details" name="pet_details"><?php echo $row['pet_details']; ?></textarea>

                <label for="lost_date">Lost Date:</label>
                <input type="date" id="lost_date" name="lost_date" value="<?php echo $row['lost_date']; ?>">

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>">
                
                <!-- Display pet photo -->
                <label for="pet_photo">Pet Photo:</label>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['pet_photo']); ?>" alt="Pet Photo" style="max-width: 100%; height: auto;">
                
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</body>
</html>
