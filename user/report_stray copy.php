<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/bc/img/main_icon.png">
    <link rel="stylesheet" href="/bc/css/found.css">
    <title>Report Stray Pet</title>
</head>
<body style="background-image: url('/bc/img/smoke.png');">
<?php include 'C:/xampp/htdocs/bc/glbl/navbar.php'; ?>
<img src="/bc/img/dog1.png" alt="Description of the image" class="img-container">

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

    <label id="termsCheckboxLabel" for="termsCheckbox">
        <input type="checkbox" id="termsCheckbox" name="termsCheckbox" required>
        I have read and agree to the <a href="/bc/glbl/link_to_terms_of_use.html" target="_blank">Terms</a> and <a href="/bc/glbl/link_to_privacy_policy.html" target="_blank">Privacy Policy</a>.
    </label>
    <br>

    <input type="submit" value="Submit">
</form>

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
