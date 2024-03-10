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

// Check if ID parameter is passed in the URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare a delete statement
    $sql = "DELETE FROM stray_pets WHERE id = ?";

    if($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $id);

        // Attempt to execute the prepared statement
        if($stmt->execute()) {
            // Redirect to the main page after deletion
            header("Location: /bc/admin/pending_stray_pet.php");
            exit();
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
