<?php
include '../config/conn.php';

$isCategory = isset($_GET["category"]);
$category = $isCategory ? $_GET["category"] : null;

// Retrieve data from the not_found_pets table
$sql1 = "SELECT pet_id, pet_name, lost_date, details, pet_type, photo, pet_img FROM not_found_pets WHERE pet_type = '$category'";
$sql2 = "SELECT pet_id, pet_name, lost_date, details, pet_type, photo, pet_img FROM not_found_pets ";
$result = $conn->query($category && $category != 'All' ? $sql1 : $sql2);



// REPORT Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    // Validate and sanitize form data
    $owner_name = mysqli_real_escape_string($conn, $_POST['ownerName']);
    $pet_name = mysqli_real_escape_string($conn, $_POST['petName']);
    $pet_details = mysqli_real_escape_string($conn, $_POST['desc']);
    $lost_date = mysqli_real_escape_string($conn, $_POST['lostDate']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $pet_type = mysqli_real_escape_string($conn, $_POST['petType']);

    // Store pet type based on selected value or other text input
    // if ($_POST['pet_type'] == "Other") {
    //     $pet_type = $_POST['other_pet_type'];
    // } else {
    //     $pet_type = $_POST['pet_type'];
    // }

    // Handle file uploads (assuming you have a directory named 'uploads' to store the images)
    $timestamp = time();
    $pet_image_path = "../uploads/" . $timestamp . "_" . basename($_FILES['petImg']['name']);
    $valid_id_image_path = "../uploads/" . $timestamp . "_" . basename($_FILES['idImg']['name']);

    $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
    $fileSize = $image["size"];

    // Move uploaded files to the 'uploads' directory
    move_uploaded_file($_FILES['petImg']['tmp_name'], $pet_image_path);
    move_uploaded_file($_FILES['idImg']['tmp_name'], $valid_id_image_path);

    // Image handling
    try {
        if (isset($_FILES['idImg']['tmp_name']) && isset($_FILES['petImg']['tmp_name'])) {
            $valid_id_photo = $_FILES['idImg']['tmp_name'];
            $pet_photo = $_FILES['petImg']['tmp_name'];

            if ($valid_id_photo && $pet_photo) {
                // Read image file content
                $valid_id_photo_content = file_get_contents($valid_id_photo);
                $pet_photo_content = file_get_contents($pet_photo);

                // Prepare SQL statement
                $sql = "INSERT INTO add_pet (owner_name, pet_name, pet_details, lost_date, valid_id_photo, pet_photo, address, pet_type, email, phone, pet_img, id_img) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                if ($stmt = $conn->prepare($sql)) {
                    // Bind parameters
                    $stmt->bind_param("ssssssssssss", $owner_name, $pet_name, $pet_details, $lost_date, $valid_id_photo_content, $pet_photo_content, $address, $pet_type, $email, $phone, $pet_image_path, $valid_id_image_path);

                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        // echo "Form submitted successfully!";
                        header('Location: lost.php');
                        exit();
                    } else {
                        throw new Exception("ERROR: Could not execute query: $sql. " . $stmt->error);
                    }
                } else {
                    throw new Exception("ERROR: Could not prepare statement: $sql. " . $conn->error);
                }
            } else {
                throw new Exception("ERROR: One or both photos are missing.");
            }
        } else {
            throw new Exception("ERROR: Photo files not uploaded.");
        }
    } catch (Exception $e) {
        echo "Caught exception: " . $e->getMessage();
    }
}


// I FOUND PET FORM SUBMISSION
if (isset($_POST['foundPetSubmit'])) {
    // Get values from the form
    $pet_id = mysqli_real_escape_string($conn, $_POST['pet_id']);
    $foundName = mysqli_real_escape_string($conn, $_POST['foundName']);
    $foundDets = mysqli_real_escape_string($conn, $_POST['foundDets']);

    // Handling file uploads (assuming 'vID' and 'fPetImg' are file inputs)
    $timestamp = time();
    $pet_image = "../uploads/found_pet_report/" . $timestamp . "_" . basename($_FILES['vID']['name']);
    $valid_id_image = "../uploads/found_pet_report/"  . $timestamp . "_"  .  basename($_FILES['fPetImg']['name']);

    // Move uploaded files to the 'uploads' directory.
    move_uploaded_file($_FILES['vID']['tmp_name'], $valid_id_image);
    move_uploaded_file($_FILES['fPetImg']['tmp_name'], $pet_image);

    // Insert data into the 'found_pets' table
    $insert_sql = "INSERT INTO found_pets (pet_id, found_name, found_details, found_img, id_img) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    // Set the status as 0 (not resolved) when inserting data
    $status = 0;
    $stmt->bind_param("issss", $pet_id, $foundName,  $foundDets,  $pet_image, $valid_id_image,);


    if ($stmt->execute()) {
        header('Location: lost.php');
        exit();
    } else {
        echo "Error storing found pet details: " . $stmt->error;
    }
}

?>
<?php include '../includes/main-wrapper.php' ?>


<div class="bg-info-subtle">
    <?php include '../includes/navbar.php' ?>
</div>
<div style="background-color: #02C5BD;" class="">
    <?php include '../includes/header-filter.php' ?>
</div>

<!-- VIEW PET DETAILS Modal -->
<div class="modal fade" id="PetFoundModal" tabindex="-1" aria-labelledby="PetFoundModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="PetFoundModal">Pet Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <figure class="col-md-6 figure float-start">
                        <img src="../img/a.png" id="MLostPetImg" class="figure-img img-fluid rounded" alt="image">
                        <figcaption class="figure-caption ">
                            <button data-bs-toggle="modal" data-bs-target="#FoundPetModal" type="button" class="w-100 btn btn-primary">I Found This Pet</button>
                        </figcaption>
                    </figure>
                    <article class="col d-flex gap-2 ">
                        <div style="min-width: 6rem; " class="">
                            <h6 class="fw-semibold">Name :</h6>
                            <h6 class="fw-semibold">Last Seen :</h6>
                            <h6 class="fw-semibold">Gender :</h6>
                            <h6 class="fw-semibold">Reward :</h6>
                            <h6 class="fw-semibold">Category :</h6>
                            <h6 class="fw-semibold">Description :</h6>
                        </div>
                        <div class="fw-light text-muted">
                            <h6 id="MLostPetName" class="">name</h6>
                            <h6 id="MLostPetDate" class="">last seen</h6>
                            <h6 id="MLostPetGender" class="">Male</h6>
                            <h6 id="MLostPetReward" class="">$10,000</h6>
                            <h6 id="MLostPetCategory" class="">category</h6>
                            <h6 id="MLostPetDesc" class="text-wrap">description</h6>
                        </div>
                    </article>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- REPORT I FOUND PET MODAL  -->
<div class="modal fade" id="FoundPetModal" tabindex="-1" aria-labelledby="FoundPetModal" aria-hidden="true">
    <div class="modal-dialog ">
        <form class="modal-content" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="FoundPetModal">Report Found Pet</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="hidden" class="form-control" id="pet_id" name="pet_id">
                    <label for="foundName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="foundName" name="foundName" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label for="foundDets" class="form-label">Details</label>
                    <textarea class="form-control" id="foundDets" rows="3" name="foundDets" placeholder="Enter details here..." required></textarea>
                </div>
                <div class="mb-3">
                    <label for="vID" class="form-label">Valid ID</label>
                    <input type="file" accept="image/*" class="form-control" name="vID" id="vID" required>
                </div>
                <div class="mb-3">
                    <label for="fPetImg" class="form-label">Pet Image</label>
                    <input type="file" accept="image/*" class="form-control" name="fPetImg" id="fPetImg" required>
                </div>
                <div class="mb-3">
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox" id="termspolicy" required>
                        <label class="form-check-label" for="termspolicy">
                            I have read and agree to the <a href="/bc/glbl/link_to_terms_of_use.html" target="_blank">Terms</a> and <a href="/bc/glbl/link_to_privacy_policy.html" target="_blank">Privacy Policy</a>.
                        </label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="foundPetSubmit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- REPORT LOST PET MODAL  -->
<div class="modal fade" id="reportPetFoundModal" tabindex="-1" aria-labelledby="reportPetFoundModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="reportPetFoundModal">Report Lost Pet</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="ownername" class="form-label ">*Name</label>
                        <input type="text" class="form-control" id="ownername" name="ownerName" placeholder="*Your name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">*Email</label>
                        <input type="text" class="form-control" placeholder="*Your email" name="email" id="email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="contact" class="form-label">*Phone</label>
                        <input type="text" class="form-control" id="contact" name="phone" placeholder="*Phone number" required>
                    </div>
                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="*Your address" required>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="petname" class="form-label">*Pet Name</label>
                        <input type="text" class="form-control" id="petname" name="petName" required placeholder="*Your pet name">
                    </div>
                    <div class="col-md-4">
                        <label for="pet_type" class="form-label">*Pet Type</label>
                        <select id="pet_type" name="petType" required class="form-select" aria-label="Default select example">
                            <option selected>*Select Pet Type</option>
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                            <option value="Bird">Bird</option>
                            <option value="Hen">Hen</option>
                            <option value="Rabbit">Rabbit</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="lostDate" class="form-label">*Lost Date</label>
                        <input type="date" class="form-control" name="lostDate" id="lostDate" required>
                    </div>
                    <div class="col-md-6">
                        <label for="petImg" class="form-label">*Pet Image</label>
                        <input type="file" accept="image/*" class="form-control" name="petImg" id="petImg" required>
                    </div>
                    <div class="col-md-6">
                        <label for="idImg" class="form-label">*Valid ID Image</label>
                        <input type="file" accept="image/*" class="form-control" name="idImg" id="idImg" required>
                    </div>
                    <div class="col-12">
                        <label for="desc" class="form-label">*Description</label>
                        <textarea class="form-control" id="desc" name="desc" required name="desc" placeholder="Pet description..."></textarea>
                    </div>

                    <div class="col-12 d-flex justify-content-center pt-2">
                        <div class="form-check ">
                            <input class="form-check-input" type="checkbox" id="termspolicy" required>
                            <label class="form-check-label" for="termspolicy">
                                I have read and agree to the <a href="/bc/glbl/link_to_terms_of_use.html" target="_blank">Terms</a> and <a href="/bc/glbl/link_to_privacy_policy.html" target="_blank">Privacy Policy</a>.
                            </label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>

<!-- PETS SECTION -->
<section class=" " style="background-color: #fafdff">
    <div class="container">
        <div id="lostPetContainer" class="pets-card-wrapper p-2">
            <!-- <div data-bs-toggle="modal" data-bs-target="#PetFoundModal" class="pet-card border border-1 border-info-subtle rounded-4 overflow-hidden" style="background-color: #ffff">
                <figure class="overflow-hidden">
                    <img src="../img/a.png" alt="pet" />
                </figure>

                <article class="d-flex gap-2 px-2 pt-1 pb-4">
                    <div>
                        <h6 class="fw-semibold">Name :</h6>
                        <h6 class="fw-semibold">Last Seen :</h6>
                        <h6 class="fw-semibold">Gender :</h6>
                        <h6 class="fw-semibold">Reward :</h6>
                        <h6 class="fw-semibold">Category :</h6>
                        <h6 class="fw-semibold">Description :</h6>
                    </div>
                    <div class="fw-light text-muted">
                        <h6 class="description-truncate">sasasa</h6>
                        <h6 class="description-truncate">sasasa</h6>
                        <h6 class="description-truncate">Male</h6>
                        <h6 class="description-truncate">$10,000</h6>
                        <h6 class="description-truncate">ssasa</h6>
                        <h6 class="description-truncate">sasasa</h6>
                    </div>
                </article>

            </div> -->

            <?php

            while ($row = $result->fetch_assoc()) {
            ?>
                <div data-bs-toggle="modal" data-bs-target="#PetFoundModal" id="pet-det-card-<?php echo $row["pet_id"]; ?>" class="pet-card pet-det-card border border-1 border-info-subtle rounded-4 overflow-hidden" style="background-color: #ffff">
                    <figure class="overflow-hidden">
                        <!-- <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($row["photo"]); ?>" alt="pet" /> -->
                        <img src="<?php echo  $row["pet_img"]; ?>" id="lostPetImg-<?php echo $row["pet_id"]; ?>" alt="pet" />
                    </figure>

                    <article class="d-flex gap-2 px-2 pt-1 pb-4">
                        <div>
                            <h6 class="fw-semibold">Name :</h6>
                            <h6 class="fw-semibold">Last Seen :</h6>
                            <h6 class="fw-semibold">Gender :</h6>
                            <h6 class="fw-semibold">Reward :</h6>
                            <h6 class="fw-semibold">Category :</h6>
                            <h6 class="fw-semibold">Description :</h6>
                        </div>
                        <div class="fw-light text-muted">
                            <h6 id="lostPetName-<?php echo $row["pet_id"]; ?>" class="description-truncate"><?php echo  $row["pet_name"]; ?></h6>
                            <h6 id="lostPetDate-<?php echo $row["pet_id"]; ?>" class="description-truncate"><?php echo  date('F j, Y', strtotime($row["lost_date"])); ?></h6>
                            <h6 id="lostPetGender-<?php echo $row["pet_id"]; ?>" class="description-truncate">Male</h6>
                            <h6 id="lostPetReward-<?php echo $row["pet_id"]; ?>" class="description-truncate">$10,000</h6>
                            <h6 id="lostPetCategory-<?php echo $row["pet_id"]; ?>" class="description-truncate"><?php echo $row["pet_type"]; ?></h6>
                            <h6 id="lostPetDesc-<?php echo $row["pet_id"]; ?>" class="description-truncate"><?php echo $row["details"]; ?></h6>
                        </div>
                    </article>
                </div>
            <?php
            }
            ?>

        </div>
    </div>

    <?php include '../includes/main-wrapper-close.php' ?>


    <style>
        /* PETS CARDS SECTION */

        .pets-card-wrapper {
            display: grid;
            /* grid-template-columns: repeat(4, 1fr); */
            /* grid-template-rows: repeat(4, auto); */
            gap: 1rem;
        }

        .pet-card {
            /* box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px; */
            /* box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; */
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
            cursor: pointer;
            border-color: #cd5c08 !important;
        }

        .pet-card figure img {
            height: 10rem;
            /* max-height: 10rem; */
            width: 100%;
            aspect-ratio: 16/9;
            /* object-fit: cover; */
        }

        .pet-card figure:hover img {
            scale: 1.2;
            transform: translateX(1rem);
            transition: all 250ms ease-in-out;
        }

        .description-truncate {
            width: 8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* MEDIUM SCREEN */
        @media only screen and (min-width: 768px) {
            .pets-card-wrapper {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* LARGE SCREEN */
        @media only screen and (min-width: 992px) {
            .pets-card-wrapper {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>

    <!--SCRIPT FOR LIVE FILTERING -->
    <script>
        function handleSearchInput(inputId) {
            var input, container, cards, petNames, i, txtValue;
            input = document.getElementById(inputId).value.toUpperCase();

            container = document.getElementById('lostPetContainer');
            cards = container.getElementsByClassName('pet-card');
            var hasResults = false;

            for (i = 0; i < cards.length; i++) {
                petNames = cards[i].querySelector('#lostPetName');
                petDesc = cards[i].querySelector('#lostPetDesc');
                txtValue = petNames.textContent || petNames.innerText;

                if (txtValue.toUpperCase().indexOf(input) > -1) {
                    cards[i].style.display = "";
                    hasResults = true;
                } else {
                    cards[i].style.display = "none";
                }
            }
        }

        document.getElementById("searchInput1").addEventListener("input", function() {
            handleSearchInput("searchInput1");
        });

        document.getElementById("searchInput2").addEventListener("input", function() {
            handleSearchInput("searchInput2");
        });
    </script>

    <script>
        // Retrieve PHP details array and convert it to JavaScript array
        var detailsArray = <?php echo json_encode($details); ?>;

        document.getElementById("searchButton").addEventListener("click", function() {
            var input, filter, container, cards, details, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toUpperCase();
            container = document.getElementById('lostPetContainer');
            cards = container.getElementsByClassName('pet-card');
            // var noResultsMessage = document.getElementById("noResultsMessage");
            // var hasResults = false;

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
            var container = document.getElementById('lostPetContainer');
            var cards = container.getElementsByClassName('pet-card');
            for (var i = 0; i < cards.length; i++) {
                cards[i].style.display = ""; // Show all cards
            }
        });
    </script>

    <!-- SET THE TEXT CONTENT IN PET DETAILS MODAL -->
    <script>
        $(".pet-det-card").on("click", function() {
            const id = $(this).attr('id').substr(-2);
            const img = $("#lostPetImg-" + id).attr("src")

            $("#pet_id").val(id)
            $("#MLostPetImg").attr("src", img)
            $("#MLostPetName").text($("#lostPetName-" + id).text())
            $("#MLostPetDate").text($("#lostPetDate-" + id).text())
            $("#MLostPetGender").text($("#lostPetGender-" + id).text())
            $("#MLostPetReward").text($("#lostPetReward-" + id).text())
            $("#MLostPetCategory").text($("#lostPetCategory-" + id).text())
            $("#MLostPetDesc").text($("#lostPetDesc-" + id).text())
        })
    </script>