<?php
// Replace these variables with your actual MySQL database credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "bcdb";

// Create a MySQL connection
$mysqli = new mysqli($host, $username, $password, $database);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the event ID from the POST data
$event_id = isset($_POST['event_id']) ? $_POST['event_id'] : null;

// Retrieve event details based on the event ID
$sql = "SELECT * FROM news_event WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the event exists
if ($result && $result->num_rows > 0) {
    $event = $result->fetch_assoc();

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_participation'])) {
        // Get data from the form
        $owner_name = isset($_POST['owner_name']) ? $_POST['owner_name'] : null;
        $pet_name = isset($_POST['pet_name']) ? $_POST['pet_name'] : null;
        $pet_age = isset($_POST['pet_age']) ? $_POST['pet_age'] : null;
        $pet_breed = isset($_POST['pet_breed']) ? $_POST['pet_breed'] : null;

        // Handle file upload for pet photo
        $pet_photo = null;
        if (isset($_FILES['pet_photo']) && $_FILES['pet_photo']['error'] == 0) {
            $pet_photo = file_get_contents($_FILES['pet_photo']['tmp_name']);
        }

        // Insert data into the participants table
        $sql = "INSERT INTO participants (event_id, owner_name, pet_name, pet_age, pet_photo, pet_breed) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("isissb", $event_id, $owner_name, $pet_name, $pet_age, $pet_photo, $pet_breed);

        if ($stmt->execute()) {
            echo "Participation successfully recorded!";
        } else {
            echo "Error recording participation: " . $stmt->error;
        }
    }
} else {
    // Event not found
    echo "<h1>Event not found</h1>";
}

// Close the MySQL connection
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/bc/img/main_icon.png">
    <link rel="stylesheet" href="/bc/css/participate.css">
    <title>Participate Form</title>
</head>

<body style="background-image: url('/bc/img/smoke.png');">
    <?php include 'C:/xampp/htdocs/bc/glbl/navbar.php'; ?>

    <!-- Display event details and participation form side by side -->
    <div class="container">
        <!-- Event details -->
        <div class="event-details">
            <h3><?php echo $event['title']; ?></h3>
            <p><strong>When:</strong> <?php echo $event['when_datetime']; ?></p>
            <p><?php echo $event['description']; ?></p>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($event['picture']); ?>" alt="Event Picture">
        </div>

        <!-- Participation form -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" class="form">
            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">

            <h2>Participation Form</h2>

            <!-- Owner name -->
            <label for="owner_name">Owner Name:</label>
            <input type="text" id="owner_name" name="owner_name" required>

            <!-- Pet name -->
            <label for="pet_name">Pet Name:</label>
            <input type="text" id="pet_name" name="pet_name" required>

            <!-- Age of pet -->
            <label for="pet_age">Age of Pet:</label>
            <input type="number" id="pet_age" name="pet_age" required>

            <!-- Photo of pet -->
            <label for="pet_photo">Photo of Pet:</label>
            <input type="file" id="pet_photo" name="pet_photo" accept="image/*" required>

            <!-- Pet breed -->
            <label for="pet_breed">Pet Breed:</label>
            <input type="text" id="pet_breed" name="pet_breed" required>

            <!-- Terms and Policy -->
            <label id="termsCheckboxLabel" for="termsCheckbox">
                <input type="checkbox" id="termsCheckbox" name="termsCheckbox" required>
                I have read and agree to the <a href="/bc/glbl/link_to_terms_of_use.html" target="_blank">Terms</a> and <a href="/bc/glbl/link_to_privacy_policy.html" target="_blank">Privacy Policy</a>.
            </label>

            <!-- Submit button -->
            <input type="submit" value="Submit Participation" name="submit_participation" class="button-part">
        </form>
    </div>

    <!-- Script for form validation -->
    <script>
        function validateForm() {
            var checkbox = document.getElementById("termsCheckbox");
            if (!checkbox.checked) {
                alert("Please agree to the Terms and Privacy Policy before submitting.");
                return false;
            }
            return true;
        }
    </script>

    <?php include 'C:/xampp/htdocs/bc/glbl/footer.php'; ?>
</body>

</html>