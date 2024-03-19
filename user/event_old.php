<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/bc/img/main_icon.png">
    <link rel="stylesheet" href="/bc/css/event.css">
    <title>Event</title>
</head>
<body style="background-image: url('/bc/img/smoke.png');">

<?php include 'C:/xampp/htdocs/bc/glbl/navbar.php';?>

<div class="slideshow-container">
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

    // Query to retrieve data from the 'event' table
    $sql = "SELECT * FROM news_event ORDER BY when_datetime DESC";
    $result = $mysqli->query($sql);

    // Check if there are any rows returned
    if ($result && $result->num_rows > 0) {
        // Output data in a continuous format
        while ($row = $result->fetch_assoc()) {
            echo '<div class="event-card">';
            echo '<div class="event-details">';
            echo '<h3>' . $row['title'] . '</h3>';
            echo '<p><strong>When:</strong> ' . $row['when_datetime'] . '</p>';
            echo '<p>' . $row['description'] . '</p>';
            echo '<form action="participate.php" method="post">';
            echo '<input type="hidden" name="event_id" value="' . $row['id'] . '">';
            echo '<button type="submit" class="button-participate">Participate</button>';
            echo '</form>';
            echo '</div>';
            echo '<div class="event-image">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['picture']) . '" alt="Event Picture" style="width: 100%; height: auto;">';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "<h1>No Events</h1>";
    }

    // Close the MySQL connection
    $mysqli->close();
    ?>
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>

<?php include 'C:/xampp/htdocs/bc/glbl/footer.php';?>

<script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("event-card");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex-1].style.display = "flex";
    }
</script>

</body>
</html>