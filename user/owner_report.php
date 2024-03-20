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

        // Prepare and execute the query to insert release request
        $sql = "INSERT INTO release_requests (pet_id, requester_name, requester_contact, release_reason, past_photo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssb", $pet_id, $requester_name, $requester_contact, $release_reason, $past_photo_data);
        

        // Upload and bind the photo data only if files were uploaded
        $past_photo_data = isset($_FILES['past_photo']['tmp_name']) ? file_get_contents($_FILES['past_photo']['tmp_name']) : null;

        if ($stmt->execute()) {
            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Success!",
                    text: " Release Request Submitted Successfully!.",
                    icon: "success",
                    confirmButtonColor: "#16a34a",
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
<br>


<div class="formbold-main-wrapper">

  <div class="formbold-form-wrapper">
    <form action="" method="post" enctype="multipart/form-data" class="found-form">
      <h2 class="mb-4">Release Request</h2>
      <input type="hidden" name="pet_id" value="<?php echo htmlspecialchars($_POST['pet_id'] ?? ''); ?>">
      
      <div class="formbold-input-flex">
        <div>
          <label for="requester_name" class="formbold-form-label"><i class="fas fa-user"></i> Your Name:</label>
          <input type="text" class="formbold-form-input" name="requester_name" id="requester_name" required>
        </div>
        <div>
          <label for="requester_contact" class="formbold-form-label"><i class="fas fa-phone"></i> Your Contact:</label>
          <input type="text" class="formbold-form-input" name="requester_contact" id="requester_contact" required>
        </div>
      </div>
      
      <div>
        <label for="release_reason" class="formbold-form-label"><i class="fas fa-info-circle"></i> Reason for Release:</label>
        <textarea class="formbold-form-input" name="release_reason" id="release_reason" rows="4" required></textarea>
      </div>
      
      <div class="formbold-input-flex">
        <div>
          <label for="past_photo" class="formbold-form-label"><i class="fas fa-image"></i> Past Photo with Pet:</label>
          <input type="file" class="formbold-form-input" name="past_photo" id="past_photo" accept="image/jpeg" required>
        </div>
        <!--
        <div>
          <label for="valid_id_photo" class="formbold-form-label"><i class="fas fa-id-card"></i> Valid ID Photo:</label>
          <input type="file" class="formbold-form-input" name="valid_id_photo" id="valid_id_photo" accept="image/jpeg" required>
        </div>

        -->
      </div>
      
      <button type="submit" class="formbold-btn"><i class="fas fa-paper-plane"></i> Submit Release Request</button>
    </form>
  </div>
</div>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  body {
    font-family: "Inter", sans-serif;
  }
  .formbold-main-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px;
  }

  .formbold-form-wrapper {
    margin: 0 auto;
    max-width: 550px;
    width: 100%;
    background: white;
  }

  .formbold-input-flex {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
  }
  .formbold-input-flex > div {
    width: 50%;
  }

  .formbold-input-radio-wrapper {
    margin-bottom: 28px;
  }
  .formbold-radio-flex {
    display: flex;
    align-items: center;
    gap: 15px;
  }
  .formbold-radio-label {
    font-size: 14px;
    line-height: 24px;
    color: #07074D;
    position: relative;
    padding-left: 25px;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }
  .formbold-input-radio {
    position: absolute;
    opacity: 0;
    cursor: pointer;
  }
  .formbold-radio-checkmark {
    position: absolute;
    top: -1px;
    left: 0;
    height: 18px;
    width: 18px;
    background-color: #FFFFFF;
    border: 1px solid #DDE3EC;
    border-radius: 50%;
  }
  .formbold-radio-label .formbold-input-radio:checked ~ .formbold-radio-checkmark {
    background-color: #6A64F1;
  }
  .formbold-radio-checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }

  .formbold-radio-label .formbold-input-radio:checked ~ .formbold-radio-checkmark:after {
    display: block;
  }

  .formbold-radio-label .formbold-radio-checkmark:after {
    top: 50%;
    left: 50%;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #FFFFFF;
    transform: translate(-50%, -50%);
  }

  .formbold-form-input {
    width: 100%;
    padding: 13px 22px;
    border-radius: 5px;
    border: 1px solid #DDE3EC;
    background: #FFFFFF;
    font-weight: 500;
    font-size: 16px;
    color: #07074D;
    outline: none;
    resize: none;
  }
  .formbold-form-input::placeholder {
    color: #536387;
  }
  .formbold-form-input:focus {
    border-color: #6a64f1;
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
  }
  .formbold-form-label {
    color: #07074D;
    font-size: 14px;
    line-height: 24px;
    display: block;
    margin-bottom: 10px;
  }

  .formbold-btn {
    text-align: center;
    width: 100%;
    font-size: 16px;
    border-radius: 5px;
    padding: 14px 25px;
    border: none;
    font-weight: 500;
    background-color: #16a34a;
    color: white;
    cursor: pointer;
    margin-top: 25px;
  }
  .formbold-btn:hover {
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
  }
  .formbold-main-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px; /* Adjusted padding */
  max-width: 100%; /* Adjusted max-width */
  height: 100vh; /* Set height to occupy full viewport */
  background-color: #f9f9f9; /* Added background color */
}

.formbold-form-wrapper {
  margin: 0 auto;
  max-width: 550px;
  width: 100%;
  background: white;
  border-radius: 10px; /* Added border radius */
  padding: 30px; /* Added padding */
  box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1); /* Added shadow */
}

/* Rest of your existing CSS styles remain unchanged */

</style>



<!-- Include Bootstrap and jQuery JavaScript files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<?php include '../includes/main-wrapper-close.php' ?>


<?php include '../includes/footer.php'; ?>

