<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/bc/img/main_icon.png">
    <title>Sheltered Pets</title>
    <link rel="stylesheet" href="/bc/css/lost.css">
</head>
<body style="background-image: url('/bc/img/smoke.png');">
<?php include('../includes/structure-head.php'); ?>
<?php include('../includes/navbar.php'); ?>

<div class="container">

            <div class="row height d-flex justify-content-center align-items-center">

              <div class="col-md-6">

                <div class="form">
                  <i class="fa fa-search"></i>
                  <input type="text" class="form-control form-input" placeholder="Search anything...">
                  <span class="left-pan"><i class="fa fa-microphone"></i></span>
                </div>
                
              </div>
              
            </div>
            
          </div>

<div id="petContainer" class="pet-container">

<?php
// Connect to your database (replace these variables with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = ""; // No password for root user
$dbname = "bcdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the sheltered_pets table
$sql = "SELECT pet_id, pet_name, intake_date, details, photo, pet_type FROM sheltered_pets";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $details = []; // Initialize an empty array to store pet details for JavaScript filtering
    while ($row = $result->fetch_assoc()) {
        echo '<div class="pet-card">';
        echo "<strong>Pet Name:</strong> " . $row["pet_name"] . "<br>";
        echo "<strong>Sheltered Date:</strong> " . date('F j, Y', strtotime($row["intake_date"])) . "<br>";
        echo "<strong>Pet Type:</strong> " . $row["pet_type"] . "<br>";
        echo "<strong>Details:</strong> " . $row["details"] . "<br>";

        // Store details in a variable for JavaScript filtering
        $details[] = $row["details"] . ' ' . $row["pet_type"];

        // Display the pet's photo
        echo '<div class="pet-img-container">';
        echo '<img src="data:image/jpeg;base64,' . base64_encode($row["photo"]) . '" alt="Pet Photo">';
        echo '</div>';

        // Add a button to redirect to found_pet_page.php
        echo '<form action="/bc/user/owner_report.php" method="post">';
        echo '<input type="hidden" name="pet_id" value="' . $row["pet_id"] . '">';
        echo '<input type="submit" value="I AM THE OWNER">';
        echo '</form>';

        echo "</div>";
    }
}

$conn->close();
?>

<!-- No results found message -->
<div id="noResultsMessage" class="no-results" style="display: none;">No results found</div>

</div>

<?php include 'C:/xampp/htdocs/bc/glbl/footer.php';?>

<script>
// Retrieve PHP details array and convert it to JavaScript array
var detailsArray = <?php echo json_encode($details); ?>;

document.getElementById("searchButton").addEventListener("click", function() {
    var input, filter, container, cards, details, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    container = document.getElementById('petContainer');
    cards = container.getElementsByClassName('pet-card');
    var noResultsMessage = document.getElementById("noResultsMessage");
    var hasResults = false;

    for (i = 0; i < cards.length; i++) {
        details = detailsArray[i]; // Get the details from the PHP array
        txtValue = details.toUpperCase();
        if (txtValue.indexOf(filter) > -1) {
            cards[i].style.display = ""; // Show the card
            hasResults = true;
        } else {
            cards[i].style.display = "none"; // Hide the card
        }
    }

    if (!hasResults) {
        noResultsMessage.style.display = "block";
    } else {
        noResultsMessage.style.display = "none";
    }
});

document.getElementById("showAllButton").addEventListener("click", function() {
    var container = document.getElementById('petContainer');
    var cards = container.getElementsByClassName('pet-card');
    for (var i = 0; i < cards.length; i++) {
        cards[i].style.display = ""; // Show all cards
    }
});
</script>

<?php include '../includes/main-wrapper-close.php' ?>