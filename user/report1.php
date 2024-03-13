<?php

include '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetching form data
    $name = $_POST['name'];
    $address = $_POST['addr'];
    $contact = $_POST['contact'];
    $reportDetails = $_POST['report_dets'];


    // Handle file uploads (assuming you have a directory named 'uploads' to store the images)
    $timestamp = time();
    $photo_path = "../uploads/report_image/" . $timestamp . "_" . basename($_FILES['photo']['name']);
    $valid_id_image_path = "../uploads/report_image/" . $timestamp . "_" . basename($_FILES['vId']['name']);

    $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
    $fileSize = $image["size"];

    // Move uploaded files to the 'uploads' directory
    move_uploaded_file($_FILES['photo']['tmp_name'],  $photo_path);
    move_uploaded_file($_FILES['vId']['tmp_name'], $valid_id_image_path);

    // Insert data into database
    $sql = "INSERT INTO reports (name, report_details, location, contact_number, photo, vId) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name,  $reportDetails,  $address, $contact,  $photo_path, $valid_id_image_path);

    if ($stmt->execute()) {
        header('Location: report.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>


<?php include '../includes/main-wrapper.php' ?>

<!-- <div class="bg-info-subtle">
    <?php include '../includes/navbar.php' ?>
</div> -->



<div style="background-color: #eee; " class="h-100 w-100">
    <section style="width: 85%; min-height: 100vh;" class="py-2 mx-auto border-2 border">
        <div class="d-flex  shadow rounded-3 ">
            <div style="width: 30%; background-color: #545871; color: rgb(241 245 249);" class="overflow-hidden p-3 position-relative rounded-start-3">
                <div class="d-flex align-items-center mb-3">
                    <img src="../img/main_icon.png" alt="logo" width="60">
                    <h5 class="fw-bold ">Beyond Collar</h5>
                </div>

                <div class="px-5 py-4 ">
                    <ul class="timeline  ">
                        <li class="timeline-item mb-4">
                            <p class="fw-medium">Owner Profile</p>
                        </li>

                        <li class="timeline-item mb-4">
                            <p class="fw-medium">Pet Basics</p>
                        </li>
                        <li class="timeline-item mb-4">
                            <p class="fw-medium">Pet Details</p>
                        </li>
                        <li class="timeline-item mb-4">
                            <p class="fw-medium">Reunite</p>
                        </li>
                    </ul>
                </div>

                <img src="../img/dog1.png" alt="dog" width="200" style="opacity: 0.5; bottom: -4rem; right: 4rem; " class="position-absolute  ">
            </div>


            <div style="background-color: white; width: 70%; " class="py-3 px-5  h-100 rounded-end-3">
                <header style="width: 90%; color: #545871;" class="fs-1 fw-bold mb-5 mx-auto">
                    Yay, we love dogs! Give us the basics about your pet.
                </header>

                <form style="width: 90%;" class="row g-2 py-2 mx-auto" method="POST" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="vID" class="form-label">Valid ID</label>
                        <input type="file" accept="image/*" class="form-control" id="vID" name="vId" required>
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="addr" required>
                    </div>
                    <div class="col-md-6">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>
                    <div class="col-md-6">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" accept="image/*" class="form-control" id="photo" name="photo" required>
                    </div>
                    <div class="col-12">
                        <label for="report_dets" class="form-label">Report Details</label>
                        <textarea class="form-control" id="report_dets" rows="3" name="report_dets" placeholder="Enter details here..." required></textarea>
                    </div>

                    <div class="pt-1 d-flex justify-content-between">
                        <a href="/bc/user/" type="button" name="" class="btn btn-outline-danger rounded-5 px-4">Back</a>
                        <button type="submit" name="" class="btn btn-primary rounded-5 px-4">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php include '../includes/main-wrapper-close.php' ?>

<style>
    .timeline {
        border-left: 1px solid hsl(0, 0%, 90%);
        position: relative;
        list-style: none;
    }

    .timeline .timeline-item {
        position: relative;
    }

    .timeline .timeline-item:after {
        position: absolute;
        display: block;
        top: 0;
    }

    .timeline .timeline-item:after {
        background-color: hsl(0, 0%, 90%);
        left: -38px;
        border-radius: 50%;
        height: 11px;
        width: 11px;
        content: "";
    }
</style>