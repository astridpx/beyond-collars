<?php include '../includes/main-wrapper.php' ?>
<?php include '../config/conn.php' ?>

<head>
    <!-- Other meta tags and stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<div class="bg-info-subtle">
    <?php include '../includes/navbar.php' ?>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pet_id'])) {
    // Check if the form fields are set before accessing them
    if(isset($_POST['requester_name']) && isset($_POST['requester_contact']) && isset($_POST['release_reason']) && isset($_FILES['valid_id_photo']['tmp_name']) && isset($_FILES['past_photo']['tmp_name'])) {
        
        $pet_id = $_POST['pet_id'];
        $requester_name = $_POST['requester_name'];
        $requester_contact = $_POST['requester_contact'];
        $release_reason = $_POST['release_reason'];

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

        // Prepare and execute the query to insert release request
        $sql = "INSERT INTO release_requests (pet_id, requester_name, requester_contact, release_reason, valid_id_photo, past_photo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssbb", $pet_id, $requester_name, $requester_contact, $release_reason, $valid_id_photo_data, $past_photo_data);

        // Upload and bind the photo data only if files were uploaded
        $valid_id_photo_data = isset($_FILES['valid_id_photo']['tmp_name']) ? file_get_contents($_FILES['valid_id_photo']['tmp_name']) : null;
        $past_photo_data = isset($_FILES['past_photo']['tmp_name']) ? file_get_contents($_FILES['past_photo']['tmp_name']) : null;

        if ($stmt->execute()) {
            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Success!",
                    text: " Release Request Submitted Successfully!.",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "OK",
                    customClass: {
                        container: "custom-sweetalert-container",
                        popup: "custom-sweetalert-popup",
                        title: "custom-sweetalert-title",
                        text: "custom-sweetalert-text",
                        confirmButton: "custom-sweetalert-confirm-button"
                    }
                });
            });
        </script>';
} else {
    echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Something Went Wrong. Please try again",
            });
        </script>';
}

        $stmt->close();
        $conn->close();
    } 
} else {
    echo "Invalid request";
}
?>
<div class="container">
    <div class="row justify-content-between">
        <div class="col-md-4">
            <div class="additional-content">
                <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="../img/cat1.png" alt="First slide" style="width: 100%;">
                        </div>
                        <div class="carousel-item">
                           <img src="../img/cat1.png" alt="First slide" style="width: 100%;">
                        </div>

                        <div class="carousel-item">
                             <img src="../img/cat1.png" alt="Second slide" style="width: 100%;">
                        </div>

                        <div class="carousel-item">
                            <img src="../img/cat1.png" alt="Third slide" style="width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-6">
            <div class="found-form-container">
                <form action="" method="post" enctype="multipart/form-data" class="found-form">
                    <h2 class="mb-4">Release Request Form</h2>
                    <input type="hidden" name="pet_id" value="<?php echo htmlspecialchars($_POST['pet_id'] ?? ''); ?>">
                    <div class="form-group">
                        <label for="requester_name"><i class="fas fa-user"></i> Your Name:</label>
                        <input type="text" class="form-control" name="requester_name" id="requester_name" required>
                    </div>
                    <div class="form-group">
                        <label for="requester_contact"><i class="fas fa-phone"></i> Your Contact:</label>
                        <input type="text" class="form-control" name="requester_contact" id="requester_contact" required>
                    </div>
                    <div class="form-group">
                        <label for="release_reason"><i class="fas fa-info-circle"></i> Reason for Release:</label>
                        <textarea class="form-control" name="release_reason" id="release_reason" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="past_photo"><i class="fas fa-image"></i> Past Photo with Pet:</label>
                        <input type="file" class="form-control-file" name="past_photo" id="past_photo" accept="image/jpeg" required>
                    </div>
                    <div class="form-group">
                        <label for="valid_id_photo"><i class="fas fa-id-card"></i> Valid ID Photo:</label>
                        <input type="file" class="form-control-file" name="valid_id_photo" id="valid_id_photo" accept="image/jpeg" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Submit Release Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('.carousel').carousel({
        interval: 2000 // Change slide every 2 seconds
    });
</script>

<style>
/* Custom Styles */

.additional-content {
    text-align: center;
}

/* Advanced CSS */

.found-form-container {
    background-color: #f0f0f0;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.found-form {
    margin-top: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #007bff;
}

.btn-primary {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
}
</style>

<!-- Include Bootstrap and jQuery JavaScript files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<?php include '../includes/main-wrapper-close.php' ?>


<?php include '../includes/footer.php'; ?>

