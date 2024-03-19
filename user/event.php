<?php
include '../config/conn.php';


$isEvent = isset($_GET["event"]);
$event_id = isset($_GET["event"]) ? $_GET["event"] : null;

// Query to retrieve data from the 'event' table
$sql = "SELECT * FROM news_event WHERE id = $event_id";
$result = $conn->query($sql);

$event = null;
if ($result->num_rows > 0) {
    // Fetch data row by row
    while ($row = $result->fetch_assoc()) {
        // Access data in $row array
        // print_r($row);
        $event = $row;
    }
}
?>

<?php include '../includes/main-wrapper.php' ?>

<div class="bg-info-subtle">
    <?php include '../includes/navbar.php' ?>
</div>

<section style="background-color: rgb(22 101 52); height:max-content; width: 100%; " class="py-4">
    <div class="row align-items-center container mx-auto ">
        <div style=" color:#fff;" class="col-md-7 text-center px-2 text-wrap position-relative">
            <h2 class="fw-bold">Paws Care
                <span>
                    <?php
                    $datetime = new DateTime($event['when_datetime']);
                    echo $datetime->format('Y');
                    ?>
                </span>
            </h2>
            <p style="color: rgb(229 231 235);" class="fw-medium">Join us at Brgy Mayapa Pet Care Event |
                <span>
                    <?php
                    $datetime = new DateTime($event['when_datetime']);
                    echo $datetime->format('F j Y');
                    ?>
                </span>
            </p>
        </div>

        <div style=" height: 15rem; " class="col">
            <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($event['picture']) ?>" style="aspect-ratio: 16/9;" class=" w-100 h-100 rounded-3 " alt="Event Image">
        </div>
    </div>
</section>
<section style="width: 100%; padding-top: 4rem;" class=" container mx-auto  ">
    <h2 class="custom-width-md  text-center text-md-start">
        <?php echo $event['title']; ?>
    </h2>

    <p class="pt-4 text-center text-md-start">
        <?php echo $event['description']; ?>
    </p>
</section>




<?php
include '../includes/footer.php';
?>

<?php include '../includes/main-wrapper-close.php' ?>



<style>
    .custom-width-md {
        width: 100%;
    }

    @media (min-width: 768px) {
        .custom-width-md {
            width: 75%;
        }
    }
</style>