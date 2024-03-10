<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bcdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the 'id' parameter is set and not empty
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    // Construct the SQL DELETE query
    $sql = "DELETE FROM add_pet WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Close connection
$conn->close();

// Redirect back to the page with the list of pets
header("Location: /bc/admin/pending_lost_pet.php");
exit();
?>
