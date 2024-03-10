<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/bc/img/main_icon.png">
    <link rel="stylesheet" href="/bc/css/found.css">
    <title>Lost Form</title>
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
    $owner_name = $_POST['owner_name'];
    $pet_name = $_POST['pet_name'];
    $pet_details = $_POST['pet_details'];
    $lost_date = $_POST['lost_date'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    // Store pet type based on selected value or other text input
    if ($_POST['pet_type'] == "Other") {
        $pet_type = $_POST['other_pet_type'];
    } else {
        $pet_type = $_POST['pet_type'];
    }

    // Image handling
    if(isset($_FILES['valid_id_photo']['tmp_name']) && isset($_FILES['pet_photo']['tmp_name'])) {
        $valid_id_photo = $_FILES['valid_id_photo']['tmp_name'];
        $pet_photo = $_FILES['pet_photo']['tmp_name'];

        if ($valid_id_photo && $pet_photo) {
            // Read image file content
            $valid_id_photo_content = file_get_contents($valid_id_photo);
            $pet_photo_content = file_get_contents($pet_photo);

            // Prepare SQL statement
            $sql = "INSERT INTO add_pet (owner_name, pet_name, pet_details, lost_date, valid_id_photo, pet_photo, address, pet_type, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                // Bind parameters
                $stmt->bind_param("ssssssssss", $owner_name, $pet_name, $pet_details, $lost_date, $valid_id_photo_content, $pet_photo_content, $address, $pet_type, $email, $phone);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    echo "Form submitted successfully!";
                } else {
                    echo "ERROR: Could not execute query: $sql. " . $stmt->error;
                }
            } else {
                echo "ERROR: Could not prepare statement: $sql. " . $conn->error;
            }

        } else {
            echo "ERROR: One or both photos are missing.";
        }
    } else {
        echo "ERROR: Photo files not uploaded.";
    }
}

?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" class="form">
    <h2>REPORT LOST PET</h2>

    <label for="owner_name">Owner Name:</label>
    <input type="text" name="owner_name" required>

    <label for="pet_name">Pet Name:</label>
    <input type="text" name="pet_name" required>

    <label for="pet_details">Pet Details:</label>
    <textarea name="pet_details" required></textarea>

    <label for="address">Address:</label>
    <input type="text" name="address" required>

    <label for="lost_date">Lost Date:</label>
    <input type="date" name="lost_date" required>

    <label for="pet_type">Pet Type:</label>
    <select name="pet_type" id="pet_type_select" required onchange="checkOther()">
        <option value="Dog">Dog</option>
        <option value="Cat">Cat</option>
        <option value="Bird">Bird</option>
        <option value="Hen">Hen</option>
        <option value="Rabbit">Rabbit</option>
        <option value="Other">Other</option>
    </select>
    <input type="text" name="other_pet_type" id="other_pet_type_input" placeholder="Enter pet type" style="display:none;">

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

    function checkOther() {
        var select = document.getElementById("pet_type_select");
        var input = document.getElementById("other_pet_type_input");
        if (select.value === "Other") {
            input.style.display = "block";
            input.required = true;
        } else {
            input.style.display = "none";
            input.required = false;
        }
    }

</script>

<?php include 'C:/xampp/htdocs/bc/glbl/footer.php'; ?>
</body>
</html>
