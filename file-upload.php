<?php

// Establish a database connection (update with your database credentials)
$conn = new mysqli('your_host', 'your_username', 'your_password', 'your_database');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and sanitize form data
$owner_name = mysqli_real_escape_string($conn, $_POST['ownerName']);
$pet_name = mysqli_real_escape_string($conn, $_POST['petName']);
$pet_details = mysqli_real_escape_string($conn, $_POST['desc']);
$lost_date = mysqli_real_escape_string($conn, $_POST['lostDate']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$pet_type = mysqli_real_escape_string($conn, $_POST['petType']);

// Handle file uploads (assuming you have a directory named 'uploads' to store the images)
$pet_image_path = 'uploads/' . basename($_FILES['petImg']['name']);
$valid_id_image_path = 'uploads/' . basename($_FILES['idImg']['name']);

// Move uploaded files to the 'uploads' directory
move_uploaded_file($_FILES['petImg']['tmp_name'], $pet_image_path);
move_uploaded_file($_FILES['idImg']['tmp_name'], $valid_id_image_path);

// Insert data into the database
$sql = "INSERT INTO lost_pets (owner_name, pet_name, pet_details, lost_date, address, email, phone, pet_type, pet_image_path, valid_id_image_path)
        VALUES ('$owner_name', '$pet_name', '$pet_details', '$lost_date', '$address', '$email', '$phone', '$pet_type', '$pet_image_path', '$valid_id_image_path')";

if ($conn->query($sql) === TRUE) {
    echo "Record inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
