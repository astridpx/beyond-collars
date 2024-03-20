<?php include '../includes/main-wrapper.php' ?>
<?php include '../config/conn.php' ?>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="../path/to/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        /* Inline Styles */
        /* styles.css */

        /* Style for background */
        .bg-info-subtle {
            background-color: #16a34a;
            padding: 10px;
        }

        /* Style for service items */
        .service-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        /* Style for service name */
        .service-name {
            font-weight: bold;
        }

        /* Style for service location */
        .service-location {
            font-style: italic;
        }

        /* Style for service description */
        .service-description {
            margin-bottom: 10px;
        }

        /* Style for visit button */
        .visit-button {
            background-color: #16a34a;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        /* Style for service image */
        .service-image {
            display: block;
            margin-top: 10px;
            max-width: 100%;
            height: auto;
        }

        /* Style for no results message */
        .no-results {
            color: red;
        }
        



    </style>


    <?php include '../includes/navbar.php' ?>



<br>
<br>
<div class="flex justify-center items-center">
    <nav id="category-navbar" class="flex justify-center mb-8">
        <ul class="flex space-x-4">
            <li>
                <a href="#" class="button-category text-white px-4 py-2 rounded-full" data-category="veterinary" style="background-color: #16a34a;">Veterinary Care</a>
            </li>
            <li>
                <a href="#" class="button-category text-white px-4 py-2 rounded-full" data-category="grooming" style="background-color: #16a34a;">Pet Grooming</a>
            </li>
            <li>
                <a href="#" class="button-category text-white px-4 py-2 rounded-full" data-category="boarding" style="background-color: #16a34a;">Pet Boarding and Daycare</a>
            </li>
            <li>
                <a href="#" class="button-category text-white px-4 py-2 rounded-full" data-category="training" style="background-color: #16a34a;">Pet Training</a>
            </li>
        </ul>
    </nav>
</div>

<h1 class="text-4xl font-bold text-center mb-8">Display the category</h1>

<div class="flex justify-center">
    <?php
    // Check connection and handle errors
    if ($conn->connect_error) {
        die("<div class='error'>Connection failed: " . $conn->connect_error . "</div>");
    }

    // Prepare SQL query
    $category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
    $sql = "SELECT Service, Location, Description, Link, Photo FROM services";
    if (!empty($category)) {
        $sql .= " WHERE Category = '$category'";
    }

    // Execute query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) :
            ?>
            <div class='col-lg-4 mb-4'> <!-- Adjusted column width to col-lg-4 and added margin bottom -->
                <div class='service-item border rounded p-4 shadow'> <!-- Added shadow class -->
                    <h3 class='service-name text-center'><strong><?= htmlspecialchars($row["Service"]) ?></strong></h3>
                    <p class='service-location'><strong>Location:</strong> <?= htmlspecialchars($row["Location"]) ?></p>
                    <?php
                    $description = htmlspecialchars($row["Description"]);
                    $maxLength = 50; // Set the maximum length for the description

                    if (strlen($description) > $maxLength) {
                        $description = substr($description, 0, $maxLength) . "..."; // Truncate the description if it exceeds the maximum length
                    }
                    ?>

                    <p class='service-description'>
                        <strong>Description:</strong><br>
                        <?= $description ?>
                    </p>

                    <?php if (!empty($row["Photo"])) : ?>
                        <div class="d-flex justify-content-center">
                            <img src='data:image/jpeg;base64,<?= base64_encode($row["Photo"]) ?>' alt='Service Image' class='service-image mt-3 img-fluid rounded' width='200' height='200'>
                        </div>
                    <?php endif; ?>

                    <div class="text-center"> <!-- Added text-center class to center the button -->
                        <a href='<?= htmlspecialchars($row["Link"]) ?>' target='_blank' class='btn btn-primary mt-3 rounded-pill'>VISIT PAGE</a>
                    </div>
                </div> <!-- Close service-item div -->
            </div> <!-- Close col-lg-4 -->
        <?php endwhile;
    } else {
        echo "<div class='no-results'>0 results</div>";
    }

    // Close database connection
    $conn->close();
    ?>
</div> <!-- Close flex justify-center -->

<script>
    // JavaScript to handle click events on category links
    document.querySelectorAll('#category-navbar ul li a').forEach(item => {
        item.addEventListener('click', event => {
            event.preventDefault(); // Prevent the default action of the link
            var category = item.getAttribute('data-category');
            window.location.href = '?category=' + category; // Redirect to the page with the selected category

            // Display the category title
            var categoryTitle = document.querySelector('h1');
            categoryTitle.innerText = category;
        });
    });
</script>





    <?php include '../includes/main-wrapper-close.php' ?>
    <?php include '../includes/footer.php'; ?>
