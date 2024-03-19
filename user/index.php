<?php
include '../config/conn.php';

// Query to retrieve data from the 'event' table
$sql = "SELECT * FROM news_event ORDER BY when_datetime DESC";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $event_id = mysqli_real_escape_string($conn, $_POST['eventId']);
    $owner_name = mysqli_real_escape_string($conn, $_POST['ownerName']);
    $pet_name = mysqli_real_escape_string($conn, $_POST['petName']);
    $pet_age = mysqli_real_escape_string($conn, $_POST['petAge']);
    $pet_type = mysqli_real_escape_string($conn, $_POST['petType']);
    $pet_breed = mysqli_real_escape_string($conn, $_POST['petBreed']);

    $pet_photo = null;
    if (isset($_FILES['petImg']) && $_FILES['petImg']['error'] == 0) {
        $pet_photo = file_get_contents($_FILES['petImg']['tmp_name']);
    }

    $sql = "INSERT INTO participants (event_id, owner_name, pet_name, pet_age, pet_breed, pet_type, pet_photo ) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $event_id, $owner_name, $pet_name, $pet_age, $pet_breed, $pet_type, $pet_photo);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    } else {
        echo "Error recording participation: " . $stmt->error;
    }
}

?>



<style>
    swiper-container {
        width: 100%;
        height: 100%;
    }

    swiper-slide {
        background: #fff;
        width: 25rem !important;
        /* text-align: center; */
        /* font-size: 18px; */
        /* display: flex; */
        /* justify-content: center; */
        /* align-items: center; */
    }

    swiper-slide img {
        display: block;
        /* width: 100%; */
        /* height: 100%; */
        /* object-fit: cover; */
    }

    .article-desc {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        word-wrap: break-word;
        position: relative;
    }

    .article-title {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        word-wrap: break-word;
    }

    .btn-pet {
        padding: 8px 1.2rem;
        text-decoration: none;
        color: #fff;
        border: rgb(22 163 74) 2px solid;
    }

    .btn-lost {
        background-color: rgb(22 163 74);
        transition: all 150ms ease;
    }

    .btn-lost:hover {
        background-color: rgb(21 128 61);
        border: rgb(21 128 61) 2px solid;

    }

    .btn-found {
        color: rgb(21 128 61);
        transition: all 150ms ease;
    }

    .btn-found:hover {
        background-color: rgb(21 128 61);
        color: #fff;
    }
</style>

<!-- JOIN EVENT MODAL -->
<div class="modal fade" id="joinModal" tabindex="-1" aria-labelledby="joinModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="joinModal">Report Lost Pet</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <h6 style="color: rgb(5 46 22);" class="mb-0 ">**Person Details**</h6>

                    <div class="col-12">
                        <input type="hidden" class="form-control" id="eventId" name="eventId" placeholder="*Your name" required>
                        <label for="ownername" class="form-label ">*Name</label>
                        <input type="text" class="form-control" id="ownername" name="ownerName" placeholder="*Your name" required>
                    </div>

                    <h6 style="color: rgb(5 46 22);" class="pt-3 pb-2 ">**Pet Details**</h6>

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
                        <label for="pet_breed" class="form-label">*Pet Breed</label>
                        <select id="pet_breed" name="petBreed" required class="form-select" aria-label="Default select example">
                            <option selected>*Select Breed</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="petAge" class="form-label">*Pet Age</label>
                        <select id="pet_age" name="petAge" required class="form-select" aria-label="Default select example">
                            <option selected>*Select Pet Type</option>
                            <option value="1-6 months">1-6 months</option>
                            <option value="7-12 months">7-12 months</option>
                            <option value="1-2 years">1-2 years</option>
                            <option value="3-4 years">3-4 years</option>
                            <option value="5-6 years">5-6 years</option>
                            <option value="7 years above">7 years above</option>
                        </select>

                    </div>
                    <div class="col-md-6">
                        <label for="petImg" class="form-label">*Pet Image</label>
                        <input type="file" accept="image/*" class="form-control" name="petImg" id="petImg" required>
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

<?php include '../includes/main-wrapper.php' ?>


<div class="bg-info-subtle">
    <?php include '../includes/navbar.php' ?>
</div>

<section style="width: 100%; min-height: 90vh; " class="pb-2 container mx-auto mx-auto d-flex flex-column flex-md-row ">
    <img src="../img/hero-dog.png" width="650" class="img-fluid" alt="hero-img">

    <div class="d-flex justify-content-center align-items-center">
        <div class="">
            <h1 class="fs-1 fw-bold pb-2">We’re here to help you find your pet</h1>
            <p class="color: rgb(75 85 99);">Welcome to Beyond Collar: A Blossoming Sanctuary for Lost Pets and Their Devoted Families</p>

            <div class="">
                <a href="lost.php" type="button" class="btn-pet btn-lost rounded-5 me-2 fw-semibold">
                    I Lost a Pet
                </a>
                <a href="stray.php" type="button" class="btn-pet btn-found rounded-5 fw-semibold">
                    I Found a Pet
                </a>
            </div>
        </div>
    </div>
</section>

<section style=" width: 85%; height: max-content; background-color: rgb(248 250 252);" class="container mx-auto position-relative p-4 mx-auto ">
    <h5 style="color:  rgb(17 24 39);" class="mb-4">
        <spans style="color: rgb(59 130 246);"><strong>|</strong></spans> Announcements
    </h5>

    <div style="height: 35rem;" class="">
        <swiper-container class="mySwiper  h-100" pagination="true" pagination-clickable="true" navigation="true" space-between="30" centered-slides="false">

            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                <swiper-slide id="<?php echo $row['id'] ?>" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;" class="rounded-3 overflow-hidden">
                    <img style=" width: 100%; height: 50%; aspect-ratio: 16/9; cursor: pointer; " src="<?php echo 'data:image/jpeg;base64,' . base64_encode($row['picture']) ?>" height="70" width="100" class="event-view-more " alt="image">

                    <article style="gap: .6rem;cursor: pointer; " class="event-view-more d-flex p-2">
                        <div style=" min-width:4rem; height: max-content; background-color:  rgb(22 163 74); color: #fff; " class="p-2 rounded-2 text-center ">
                            <h5 class="fw-bold lh-1">
                                <?php
                                $datetime = new DateTime($row['when_datetime']);
                                echo $datetime->format('d');
                                ?>
                            </h5>
                            <h6 class="lh-1">
                                <?php
                                $datetime = new DateTime($row['when_datetime']);
                                echo $datetime->format('F');
                                ?>
                            </h6>
                        </div>
                        <div class="text-wrap pb-2  pe-2">
                            <h6 style="color:  rgb(17 24 39);" class="article-title mb-2 fw-bold fs-5">
                                <?php echo $row['title'] ?>
                            </h6>
                            <p style="font-size: 14px;" class="mb-2 "><span>
                                    <i class="bi bi-calendar-event me-1"></i></span>
                                <?php
                                // Convert datetime string to DateTime object
                                $datetime = new DateTime($row['when_datetime']);
                                // Format to display time with AM/PM indicator
                                echo $datetime->format('h:i A'); // 'h:i A' format represents hours and minutes with AM/PM
                                ?>
                            </p>
                            <p style="color: rgb(75 85 99);" class="article-desc"> <?php echo $row['description']  ?></p>
                        </div>


                    </article>
                    <div class=" w-100 d-flex justify-content-center">
                        <a data-bs-toggle="modal" data-bs-target="#joinModal" id="joinBtn" type="button" class="btn-pet  btn-found rounded-5 fw-semibold">
                            Join Now
                        </a>
                    </div>

                </swiper-slide>
            <?php
            }
            ?>
        </swiper-container>
    </div>

</section>
<?php include '../includes/footer.php'; ?>

<?php include '../includes/main-wrapper-close.php' ?>

<script>
    const swiperEl = document.querySelector('swiper-container')

    // Set the id value for hidden input  
    $("swiper-slide").on("click", function() {
        $("#eventId").val($(this).attr("id"))
    })

    // redirect to event page
    $('.event-view-more').click(function() {
        var slideId = $(this).closest('swiper-slide').attr('id');
        // console.log('Clicked swiper-slide ID:', slideId);

        window.location.href = `event.php?event=${slideId}`;
    });

    const PetBreeds = {
        Dog: [
            "Labrador Retriever",
            "German Shepherd",
            "Golden Retriever",
            "French Bulldog",
            "Bulldog",
            "Beagle",
            "Poodle",
            "Boxer",
            "Yorkshire Terrier",
            "Dachshund"
        ],
        Cat: [
            "Domestic Shorthair",
            "Domestic Longhair",
            "Siamese",
            "Maine Coon",
            "Persian",
            "Ragdoll",
            "Bengal",
            "Sphynx",
            "British Shorthair",
            "Abyssinian"
        ],
        Bird: [
            "Budgerigar",
            "Cockatiel",
            "African Grey Parrot",
            "Canary",
            "Lovebird",
            "Cockatoo",
            "Conure",
            "Macaw",
            "Finch",
            "Amazon Parrot"
        ],
        Hen: [
            "Rhode Island Red",
            "Plymouth Rock",
            "Leghorn",
            "Sussex",
            "Orpington",
            "Wyandotte",
            "Australorp",
            "Brahma",
            "Silkie",
            "Barnevelder"
        ],
        Rabbit: [
            "Mini Rex",
            "Holland Lop",
            "Netherland Dwarf",
            "Lionhead",
            "Flemish Giant",
            "Dutch Rabbit",
            "English Lop",
            "Miniature Lion Lop",
            "Angora Rabbit",
            "Miniature Satin"
        ]
    };

    $("#pet_type").on("change", function() {
        let selected = $(this).val();

        // alert($(this).val())


        // Clear existing options
        $('#pet_breed').empty();

        // Loop through the dog breeds array and create <option> elements
        $.each(PetBreeds[selected], function(index, breed) {
            $('#pet_breed').append($('<option>', {
                value: breed,
                text: breed
            }));
        });
        $('#pet_breed').append($('<option>', {
            value: "Other",
            text: "Other"
        }));
    })
</script>




<!-- SLIDER COMPONENT SAMPLE -->

<!-- <swiper-slide class="rounded-3 overflow-hidden">
    <img style=" width: 100%; height: 50%; aspect-ratio: 16/9; " height="70" width="100" src="../img/poster-2.jpg" class="" alt="image">

    <article style="gap: .6rem;" class="d-flex p-2">
        <div style="height: max-content; background-color:  rgb(37 99 235); color: #fff;" class="p-2 rounded-2 text-center ">
            <h5 class="fw-bold lh-1">30</h5>
            <h6 class="lh-1">January</h6>
        </div>

        <div class="text-wrap pb-2  pe-2">
            <h6 style="color:  rgb(17 24 39);" class="article-title mb-2 fw-bold fs-5">
                Pawsitive Protection: The Pet Vaccination & Wellness Fair
            </h6>
            <p style="font-size: 14px;" class="mb-2 "><span>
                    <i class="bi bi-calendar-event me-1"></i></span> 8:00 AM
            </p>
            <p style="color: rgb(75 85 99);" class="article-desc">Our Barangay Hosts Pet Appreciation Day: Furry Friends Take Center Stage in Community Celebration! Residents come together for a day of pet-themed fun, contests, and shared stories, fostering a sense of community around the love for our four-legged companions.</p>
        </div>

    </article> -->