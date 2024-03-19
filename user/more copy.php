<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/bc/img/main_icon.png">
    <link rel="stylesheet" type="text/css" href="/bc/css/more.css">
    <title>Services</title>
    <style>
        /* External CSS can be moved to a separate file */
        /* Styling for the category navbar */
        #category-navbar {
            min-width: 1000px;
            background-color: white;
            position: fixed;
            z-index: 999; /* Ensure the extra navbar is above the background */
            top: 100px; /* Adjust based on the height of the main navbar */
        }
        #category-navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        #category-navbar ul li {
            display: inline;
            margin-right: 20px;
        }
        #category-navbar ul li a {
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body style="background-image: url('/bc/img/smoke.png');">
    <!-- Main Navbar -->
    <?php include 'C:/xampp/htdocs/bc/glbl/navbar.php'; ?>
    
    <!-- Extra Navigation Bar -->
    <nav id="category-navbar">
        <ul>
            <li><a href="#" data-category="veterinary">Veterinary Care</a></li>
            <li><a href="#" data-category="grooming">Pet Grooming</a></li>
            <li><a href="#" data-category="boarding">Pet Boarding and Daycare</a></li>
            <li><a href="#" data-category="training">Pet Training</a></li>
        </ul>
    </nav>

    <div id="content">
        <?php
        // Database configuration
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bcdb";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection and handle errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data from the database based on the selected category
        $category = isset($_GET['category']) ? $_GET['category'] : '';
        if (isset($_GET['category'])) {
            $sql = "SELECT Service, Location, Description, Link, Photo FROM services WHERE Category = '" . $conn->real_escape_string($_GET['category']) . "'";
        } else {
            $sql = "SELECT Service, Location, Description, Link, Photo FROM services";
        }
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<div class='service-item'>";
                echo "<p class='service-name'>" . htmlspecialchars($row["Service"]) . "</p>";
                echo "<p class='service-location'>" . htmlspecialchars($row["Location"]) . "</p>";
                echo "<p class='service-description'>" . htmlspecialchars($row["Description"]) . "</p>";
                // Visit button
                echo "<a href='" . htmlspecialchars($row["Link"]) . "' target='_blank'><button class='visit-button'>VISIT PAGE</button></a>";
                echo "</div>"; // Close service-item div
                // Display image if available
                if (!empty($row["Photo"])) {
                    echo "<img src='data:image/jpeg;base64," . base64_encode($row["Photo"]) . "' alt='Service Image' class='service-image'>";
                }
            }
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </div>

    <!-- Footer -->
    <?php include 'C:/xampp/htdocs/bc/glbl/footer.php'; ?>

    <script>
        // JavaScript to handle click events on category links
        document.querySelectorAll('#category-navbar ul li a').forEach(item => {
            item.addEventListener('click', event => {
                event.preventDefault(); // Prevent the default action of the link
                var category = item.getAttribute('data-category');
                window.location.href = '?category=' + category; // Redirect to the page with the selected category
            });
        });
    </script>
</body>
</html>
