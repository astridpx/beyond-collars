<!-- MOBILE SEARCH-->
<header class="pet-search-wrapper d-block d-lg-none">
    <div class="py-4">
        <div class="container d-flex gap-4 pet-search">
            <!-- dropdown -->
            <div class="dropdown">
                <button class="btn dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span><i class="bi bi-geo-alt"></i></span> Select Location
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Mamatid</a></li>
                    <li><a class="dropdown-item" href="#">Baclaran</a></li>
                    <li>
                        <a class="dropdown-item" href="#">Pulo</a>
                        <a class="dropdown-item" href="#">San Isidro</a>
                    </li>
                </ul>
            </div>

            <input type="search" name="search" id="" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Enter your keyword here..." />

            <!-- <button type="submit" class="btn fw-semibold px-4">Find Pet</button> -->
        </div>
    </div>
</header>

<!-- SEARCH LG SCREEN-->
<header class="pet-search-wrapper d-none d-lg-block">
    <div class="py-4">
        <div class="container d-flex gap-4 pet-search">
            <!-- dropdown -->
            <div class="dropdown">
                <button class="btn btn-lg dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span><i class="bi bi-geo-alt"></i></span> Category
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Mamatid</a></li>
                    <li><a class="dropdown-item" href="#">Baclaran</a></li>
                    <li>
                        <a class="dropdown-item" href="#">Pulo</a>
                        <a class="dropdown-item" href="#">San Isidro</a>
                    </li>
                </ul>
            </div>

            <input type="search" name="search" id="" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Enter your keyword here..." />

            <button type="submit" class="btn btn-lg find-btn fw-semibold px-4">
                <!-- Find Pet -->
                Search
            </button>
        </div>
    </div>
</header>
<style>
    .pet-search button[type="submit"] {
        background-color: #ff393c;
        color: #fff;
    }

    .pet-search button[type="submit"]:hover {
        background-color: rgb(196, 48, 51);
    }
</style>

<!-- CATEGORY FILTER -->
<!-- <section class="py-4">
    <div class="container align-items-center">
        <div class="row gap-2">
            <div class="category-card pt-2 col d-flex align-items-center gap-3">
                <figure class="category-img rounded-circle">
                    <img src="./assets/pet-category/category-dog.svg" alt="category" />
                </figure>
                <article>
                    <h5 class="fw-medium category-text">Dogs</h5>
                    <span class="category-text">(10)</span>
                </article>
            </div>

            <div class="category-card pt-2 col d-flex align-items-center gap-3">
                <figure class="category-img rounded-circle">
                    <img src="./assets/pet-category/category-cats.svg" alt="category" />
                </figure>
                <article>
                    <h5 class="fw-medium pt-2 category-text">Cats</h5>
                    <span class="category-text">(10)</span>
                </article>
            </div>

            <div class="category-card pt-2 col d-flex align-items-center gap-3">
                <figure class="category-img rounded-circle">
                    <img src="./assets/pet-category/category-birds.svg" alt="category" />
                </figure>
                <article>
                    <h5 class="fw-medium category-text">Birds</h5>
                    <span class="category-text">(10)</span>
                </article>
            </div>

            <div class="category-card pt-2 col d-flex align-items-center gap-3">
                <figure class="category-img rounded-circle">
                    <img src="./assets/pet-category/category-hen.svg" alt="category" />
                </figure>
                <article>
                    <h5 class="fw-medium category-text">Hens</h5>
                    <span class="category-text">(10)</span>
                </article>
            </div>

            <div class="category-card pt-2 col d-flex align-items-center gap-3">
                <figure class="category-img rounded-circle">
                    <img src="./assets/pet-category/category-rabbit.svg" alt="category" />
                </figure>
                <article>
                    <h5 class="fw-medium category-text">Rabbits</h5>
                    <span class="category-text">(10)</span>
                </article>
            </div>

            <div class="category-card pt-2 col d-flex align-items-center gap-3">
                <figure class="category-img p-2 rounded-circle">
                    <img src="./assets/pet-category/category-others.svg" alt="category" />
                </figure>
                <article>
                    <h5 class="fw-medium category-text">Others</h5>
                    <span class="category-text">(10)</span>
                </article>
            </div>
        </div>
    </div>
</section> -->