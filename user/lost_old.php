<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/bc/img/main_icon.png">
    <title>Lost Pets</title>
    <link rel="stylesheet" href="/bc/css/lost.css">
</head>

<body style="background-image: url('/bc/img/smoke.png');">
    <?php include 'C:/xampp/htdocs/bc/glbl/navbar.php'; ?>
    <!-- Search bar container -->
    <div class="search-container">
        <!-- Search bar -->
        <input type="text" id="searchInput" placeholder="Search for pets by details...">
        <button id="searchButton">Search</button>
        <!-- Button to show all pets -->
        <button id="showAllButton">Show All</button>
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

        // Retrieve data from the not_found_pets table
        $sql = "SELECT pet_id, pet_name, lost_date, details, pet_type, photo FROM not_found_pets";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            $details = []; // Initialize an empty array to store pet details for JavaScript filtering
            while ($row = $result->fetch_assoc()) {
                echo '<div class="pet-card">';
                echo "<strong>Pet Name:</strong> " . $row["pet_name"] . "<br>";

                // Convert lost_date to a more readable format
                $lost_date = date('F j, Y', strtotime($row["lost_date"]));
                echo "<strong>Lost Date:</strong> " . $lost_date . "<br>";

                echo "<strong>Pet Type:</strong> " . $row["pet_type"] . "<br>"; // Display pet type
                echo "<strong>Details:</strong> " . $row["details"] . "<br>";

                // Store details in a variable for JavaScript filtering
                $details[] = $row["details"] . ' ' . $row["pet_type"];

                // Display the pet's photo
                echo '<div class="pet-img-container">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row["photo"]) . '" alt="Pet Photo">';
                echo '</div>';

                // Add a button to redirect to found_pet_page.php
                echo '<form action="found_pet_page.php" method="post">';
                echo '<input type="hidden" name="pet_id" value="' . $row["pet_id"] . '">';
                echo '<input type="submit" value="I FOUND THIS PET">';
                echo '</form>';

                echo "</div>";
            }
        }

        $conn->close();
        ?>


        <!-- No results found message -->
        <div id="noResultsMessage" class="no-results" style="display: none;">No results found</div>

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

        <?php include 'C:/xampp/htdocs/bc/glbl/footer.php'; ?>

</body>

</html>