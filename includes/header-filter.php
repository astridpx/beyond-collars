<!-- MOBILE SEARCH-->
<header class="pet-search-wrapper d-block d-lg-none">
    <div class="py-4">
        <div class="container d-flex gap-2 pet-search">
            <!-- dropdown -->
            <div class="dropdown">
                <button class="btn dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- <span><i class="bi bi-geo-alt"></i></span> -->
                    Category
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="?category=All">All</a></li>
                    <li><a class="dropdown-item" href="?category=Dog">Dog</a></li>
                    <li><a class="dropdown-item" href="?category=Cat">Cat</a></li>

                </ul>
            </div>

            <input type="search" id="searchInput1" name="search" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Enter your keyword here..." />

            <!-- <button type="submit" class="btn fw-semibold px-4">Find Pet</button> -->
            <button type="button" data-bs-toggle="modal" data-bs-target="#reportPetFoundModal" class="report-btn btn btn-default find-btn fw-semibold px-4">
                Report
            </button>
        </div>
    </div>
</header>

<!-- SEARCH LG SCREEN-->
<header class="pet-search-wrapper d-none d-lg-block">
    <div class="py-4">
        <div class="container d-flex gap-2 pet-search">
            <!-- dropdown -->
            <div class="dropdown">
                <button class="btn btn-lg dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- <span><i class="bi bi-geo-alt"></i></span>  -->
                    Category
                </button>
                <ul class="dropdown-menu">
                    <li class="category-item"><a class="dropdown-item" href="?category=All">All</a></li>
                    <li class="category-item"><a class="dropdown-item" href="?category=Dog">Dog</a></li>
                    <li class="category-item"><a class="dropdown-item" href="?category=Cat">Cat</a></li>
                    <!-- <li class="category-item">
                        <a class="dropdown-item" href="#">Pulo</a>
                        <a class="dropdown-item" href="#">San Isidro</a>
                    </li> -->
                </ul>
            </div>

            <input type="search" name="search" id="searchInput2" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Enter your keyword here..." />

            <button type="button" data-bs-toggle="modal" data-bs-target="#reportPetFoundModal" class="report-btn btn btn-lg find-btn fw-semibold px-4">
                Report
            </button>
        </div>
    </div>
</header>
<style>
    .pet-search .report-btn {
        background-color: #ff393c;
        color: #fff;
    }

    .pet-search .report-btn:active {
        color: #fff;
    }

    .pet-search .report-btn:hover {
        background-color: rgb(196, 48, 51);
    }
</style>

<script>
    $(document).ready(function() {
        $('.category-item').on('click', function() {
            // Get the text or value of the clicked item
            var selectedItem = $(this).text(); // or $(this).attr('href') for the value
            console.log('Selected Item:', selectedItem);

            // If you want to set the selected item text to the button
            $('.dropdown-toggle').html('<span><i class="bi bi-geo-alt"></i></span> ' + selectedItem);
        });
    });
</script>