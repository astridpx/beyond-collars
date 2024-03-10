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

// Check if ID parameter is set
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare a delete statement
    $sql = "DELETE FROM news_event WHERE id = ?";
    
    if($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);
        
        // Set parameters
        $param_id = $id;
        
        // Attempt to execute the prepared statement
        if($stmt->execute()) {
            // Redirect to admin_event.php after successful deletion
            header("Location: /bc/admin/admin_event.php");
            exit();
        } else {
            echo "ERROR: Could not execute query: $sql. " . $conn->error;
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $conn->close();
} else {
    // ID parameter is not set
    echo "Error: No ID parameter provided.";
}
?>
