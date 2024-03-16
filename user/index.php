<?php
include '../config/conn.php';

// Query to retrieve data from the 'event' table
$sql = "SELECT * FROM news_event ORDER BY when_datetime DESC";
$result = $conn->query($sql);
?>

<?php include '../includes/main-wrapper.php' ?>

<div class="bg-info-subtle">
    <?php include '../includes/navbar.php' ?>
</div>

<section style="width: 100%; height: 90vh" class="container mx-auto mx-auto d-flex ">
    <img src="../img/hero-dog.png" alt="hero-img">

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

    <div style="height: 27rem;" class="">
        <swiper-container class="mySwiper  h-100" pagination="true" pagination-clickable="false" navigation="true" slides-per-view="2" space-between="30" centered-slides="false">

            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                <swiper-slide style="box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;" class="rounded-3 overflow-hidden">
                    <img style=" width: 100%; height: 50%; aspect-ratio: 16/9; " src="<?php echo 'data:image/jpeg;base64,' . base64_encode($row['picture']) ?>" height="70" width="100" class="" alt="image">

                    <article style="gap: .6rem;" class="d-flex p-2">
                        <div style=" min-width:4rem; height: max-content; background-color:  rgb(37 99 235); color: #fff; " class="p-2 rounded-2 text-center ">
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
                </swiper-slide>
            <?php
            }


            ?>




        </swiper-container>
    </div>

</section>
<?php include '../includes/footer.php'; ?>

<?php include '../includes/main-wrapper-close.php' ?>

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
        border: rgb(37 99 235) 2px solid;
    }

    .btn-lost {
        background-color: rgb(37 99 235);
        transition: all 150ms ease;
    }

    .btn-lost:hover {
        background-color: rgb(29 78 216);
        border: rgb(29 78 216) 2px solid;

    }

    .btn-found {
        color: rgb(37 99 235);
        transition: all 150ms ease;
    }

    .btn-found:hover {
        background-color: rgb(37 99 235);
        color: #fff;
    }
</style>


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