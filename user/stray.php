<?php include '../includes/main-wrapper.php' ?>

<div class="bg-info-subtle">
    <?php include '../includes/navbar.php' ?>
</div>

<style>
.height{

height: 20vh;
}

.form{

position: relative;
}

.form .fa-search{

position: absolute;
top:20px;
left: 20px;
color: #9ca3af;

}

.form span{

    position: absolute;
right: 17px;
top: 13px;
padding: 2px;
border-left: 1px solid #d1d5db;

}

.left-pan{
padding-left: 7px;
}

.left-pan i{

padding-left: 10px;
}

.form-input{

height: 55px;
text-indent: 33px;
border-radius: 10px;
}

.form-input:focus{

box-shadow: none;
border:none;
}
</style>


<!--SEARCH BAR WITH LIVE FILTERING -->
<div class="container">
    <div class="row height d-flex justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="form">
                <i class="fa fa-search"></i>
                <input id="searchInput" type="text" class="form-control form-input" placeholder="Search Animal...">
                <span class="left-pan"><i class="fa fa-microphone"></i></span>
            </div>
        </div>
    </div>
</div>

<div id="petContainer" class="container">
    <div class="row row-cols-1 row-cols-md-4 g-4">
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
                <div class="col pet-card"> 
                    <div class="card h-100">
                        <img class="card-img-top" src="data:image/jpeg;base64,<?= base64_encode($row["photo"]) ?>" alt="Pet Photo" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row["pet_name"] ?></h5>
                            <p class="card-text"><strong>Sheltered Date:</strong> <?= date('F j, Y', strtotime($row["intake_date"])) ?></p>
                            <p class="card-text"><strong>Pet Type:</strong> <?= $row["pet_type"] ?></p>
                            <p class="card-text"><strong>Details:</strong> <?= $row["details"] ?></p>
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-outline-primary mr-2" data-bs-toggle="modal" data-bs-target="#petDetailsModal<?= $row["pet_id"] ?>">View Details</button>
                            <form action="/bc/user/owner_report.php" method="post" class="d-inline">
                                <input type="hidden" name="pet_id" value="<?= $row["pet_id"] ?>">
                                <button type="submit" class="btn btn-outline-success">I Am the Owner</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </div>
</div>


<!--SCRIPT FOR LIVE FILTERING -->
<script>


    document.getElementById("searchInput").addEventListener("input", function () {
        var input, filter, container, cards, petNames, i, txtValue;
        input = this.value.toUpperCase();
        container = document.getElementById('petContainer');
        cards = container.getElementsByClassName('pet-card');
        var noResultsMessage = document.getElementById("noResultsMessage");
        var hasResults = false;

        for (i = 0; i < cards.length; i++) {
            petNames = cards[i].getElementsByClassName('card-title')[0];
            txtValue = petNames.textContent || petNames.innerText;
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
    });



</script>




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

</body>
</html>
