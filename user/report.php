<?php
// Replace these variables with your own database details
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $name = $_POST['name'];
    $report_details = $_POST['report_details'];
    $location = $_POST['location'];
    $contact_number = $_POST['contact_number'];

    // Upload photo as BLOB
    $photo_blob = file_get_contents($_FILES["photo"]["tmp_name"]);

    // Upload valid ID photo as BLOB
    $valid_id_photo_blob = file_get_contents($_FILES["valid_id_photo"]["tmp_name"]);

    // Insert data into database
    $sql = "INSERT INTO reports (name, report_details, photo_blob, location, contact_number, valid_id_photo_blob) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssbssb", $name, $report_details, $photo_blob, $location, $contact_number, $valid_id_photo_blob);

    if ($stmt->execute()) {
        echo "Report submitted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/bc/img/main_icon.png">
    <link rel="stylesheet" href="/bc/css/report.css">
    <title>Report Form</title>
</head>
<body style="background-image: url('/bc/img/smoke.png');">

<img src="/bc/img/cat1.png" alt="Description of the image" class="img-container">
<?php include 'C:/xampp/htdocs/bc/glbl/navbar.php'; ?>

<div class="report-container">
    <h2>REPORT COMPLAIN</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" class="container">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="report_details">Report Details:</label>
        <textarea id="report_details" name="report_details" required></textarea><br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required><br>

        <label for="contact_number">Contact Number:</label>
        <input type="tel" id="contact_number" name="contact_number" required><br>

        <label for="photo">Photo:</label>
        <input type="file" id="photo" name="photo" accept="image/*"><br>

        <label for="valid_id_photo">Valid ID Photo:</label>
        <input type="file" id="valid_id_photo" name="valid_id_photo" accept="image/*"><br>

        <label id="termsCheckboxLabel" for="termsCheckbox">
        <input type="checkbox" id="termsCheckbox" name="termsCheckbox" required>
        I have read and agree to the <a href="/bc/glbl/link_to_terms_of_use.html" target="_blank">Terms</a> and <a href="/bc/glbl/link_to_privacy_policy.html" target="_blank">Privacy Policy</a>.
        </label>
        <br>

        <input type="submit" value="Submit">
    </form>
</div>

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

<?php include 'C:/xampp/htdocs/bc/glbl/footer.php';?>

</body>
</html>
