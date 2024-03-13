<?php include '../includes/main-wrapper.php' ?>

<div class="bg-info-subtle">
    <?php include '../includes/navbar.php' ?>
</div>


<!-- SEARCH BAR WITH LIVE FILTERING -->
<div class="container">
    
    <div class="row height d-flex justify-content-center align-items-center">
 
        <div class="col-md-6">
            <div class="form">
                <i class="fa fa-search"></i>
                <input id="searchInput" type="text" class="form-control form-input" placeholder="Search Animal...">
                <span class="left-pan" id="voiceSearch"><i class="fa fa-microphone"></i></span>
            </div>
        </div>
    </div>
</div>

<!-- Header -->
<div class="container">
    <div class="row">
        <div class="col text-center">
            <h2 class="fw-bold text-uppercase mt-4">LIST OF STRAY ANIMALS</h2>
        </div>
    </div>
</div>


<div id="petContainer" class="container pet-container">
    
<div class="row row-cols-1 row-cols-md-4 g-5">
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
            while ($row = $result->fetch_assoc()) {
        ?>
        
<div class="col-md-6 col-lg-4 pet-card">
    <div class="card border-0 shadow rounded">
        <div class="card-img-top rounded-top" style="background-image: url(data:image/jpeg;base64,<?= base64_encode($row["photo"]) ?>); height: 200px; background-size: cover; background-position: center;"></div>
        <div class="card-body">
            <h5 class="card-title text-center"><?= $row["pet_name"] ?></h5>
        </div>
        
      <div class="card-footer bg-light d-flex justify-content-center align-items-center rounded-bottom pb-3">
  <button type="button" class="btn btn-secondary btn-sm rounded-pill shadow me-2 px-4" data-bs-toggle="modal" data-bs-target="#petDetailsModal<?= $row["pet_id"] ?>">
    <i class="fas fa-info-circle"></i> Details <!-- Icon for Details -->
</button>

<form action="/bc/user/owner_report.php" method="post" class="d-inline">
    <input type="hidden" name="pet_id" value="<?= $row["pet_id"] ?>">
    <button type="submit" class="btn btn-info btn-sm rounded-pill shadow ms-2 px-4">
        <i class="fas fa-envelope"></i> Contact <!-- Icon for Contact -->
    </button>
</form>


</div>



    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="petDetailsModal<?= $row["pet_id"] ?>" tabindex="-1" aria-labelledby="petDetailsModalLabel<?= $row["pet_id"] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="petDetailsModalLabel<?= $row["pet_id"] ?>">Pet Details: <?= htmlspecialchars($row["pet_name"]) ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Sheltered Date:</strong> <?= date('F j, Y', strtotime($row["intake_date"])) ?></p>
                <p><strong>Pet Type:</strong> <?= htmlspecialchars($row["pet_type"]) ?></p>
                <p><strong>Details:</strong> <?= htmlspecialchars($row["details"]) ?></p>
                <!-- Additional details can be added here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
    }
} 

$conn->close();
?>
</div>
</div>

<!-- SCRIPT FOR LIVE FILTERING -->
<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        filterPets(this.value.toUpperCase());
    });

    document.getElementById("voiceSearch").addEventListener("click", function() {
        startVoiceRecognition();
    });

    function filterPets(input) {
        var container = document.getElementById('petContainer');
        var cards = container.getElementsByClassName('pet-card');
        var noResultsMessage = document.getElementById("noResultsMessage");
        var hasResults = false;

        for (var i = 0; i < cards.length; i++) {
            var petNames = cards[i].getElementsByClassName('card-title')[0];
            var txtValue = petNames.textContent || petNames.innerText;
            if (txtValue.toUpperCase().indexOf(input) > -1) {
                cards[i].style.display = "";
                hasResults = true;
            } else {
                cards[i].style.display = "none";
            }
        }

        if (!hasResults) {
            noResultsMessage.style.display = "block";
        } else {
            noResultsMessage.style.display = "none";
        }
    }

    function startVoiceRecognition() {
        var recognition = new webkitSpeechRecognition();
        recognition.continuous = false;
        recognition.interimResults = false;

        recognition.lang = "en-US";
        recognition.start();

        recognition.onresult = function(event) {
            var voiceResult = event.results[0][0].transcript;
            document.getElementById("searchInput").value = voiceResult;
            filterPets(voiceResult.toUpperCase());
            recognition.stop();
        };

        recognition.onerror = function(event) {
            console.log('Speech recognition error detected: ' + event.error);
            recognition.stop();
        };
    }
</script>

<!-- No results found message -->
<div id="noResultsMessage" class="alert alert-info text-center mt-3" role="alert" style="display: none;">
    No results found.
 
</div>

<?php include 'C:/xampp/htdocs/bc/glbl/footer.php'; ?>

</body>
</html>
