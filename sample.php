<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="index.css" />
    <title>Lost And Found</title>

    <!-- BOOTSRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />
</head>

<body>
    <div>
        <!-- <main class="container bg-info-subtle h-"> -->
        <!-- NAVBAR -->
        <?php
        include './includes/navbar.php'
        ?>
        <!-- FILTER SEARCH -->
        <?php
        include './includes/header-filter.php'
        ?>

        <!-- BREAD CRUMS -->
        <!-- <nav
        class="py-3"
        style="--bs-breadcrumb-divider: '>'; background-color: #f6f9f9"
        aria-label="breadcrumb"
      >
        <ol class="breadcrumb container px-2">
          <li class="breadcrumb-item">
            <a href="#" class="text-decoration-none">Home</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Library</li>
        </ol>
      </nav> -->



        <!-- PETS SECTION -->
        <section class=" " style="background-color: #fafdff">
            <div class="container">
                <div class="pets-card-wrapper">
                    <!-- <div class="pet-card border border-1 border-info-subtle rounded-4 overflow-hidden">
            <figure class="overflow-hidden">
              <img src="./public/zebra.jpg" alt="pet" />
            </figure>

            <article class="d-flex gap-2 px-2 pt-1 pb-4" style="background-color: #d3e9f5">
              <div>
                <h6 class="fw-semibold">Name :</h6>
                <h6 class="fw-semibold">Breed :</h6>
                <h6 class="fw-semibold">Age :</h6>
                <h6 class="fw-semibold">Gender :</h6>
                <h6 class="fw-semibold">Location :</h6>
                <h6 class="fw-semibold">Reward :</h6>
                <h6 class="fw-semibold">Description :</h6>
              </div>
              <div class="fw-light text-muted">
                <h6 class="description-truncate">Oroe</h6>
                <h6 class="description-truncate">Golden Retriever</h6>
                <h6 class="description-truncate">2 yrs old</h6>
                <h6 class="description-truncate">Male</h6>
                <h6 class="description-truncate">Mamatid</h6>
                <h6 class="description-truncate">$10,000</h6>
                <h6 class="description-truncate">
                  Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                  Deleniti, distinctio.
                </h6>
              </div>
            </article>
          </div> -->
                    <?php foreach ($pets as $index => $pet) :
                        // var_dump($pets);
                    ?>
                        <div class="pet-card border border-1 border-warning rounded-4 overflow-hidden" style="background-color: #ffff">
                            <figure class="overflow-hidden">
                                <img src="<?php echo htmlentities($pet->img); ?>" alt="pet" />
                            </figure>

                            <article class="d-flex gap-2 px-2 pt-1 pb-4">
                                <div>
                                    <h6 class="fw-semibold">Name :</h6>
                                    <h6 class="fw-semibold">Breed :</h6>
                                    <h6 class="fw-semibold">Age :</h6>
                                    <h6 class="fw-semibold">Gender :</h6>
                                    <h6 class="fw-semibold">Location :</h6>
                                    <h6 class="fw-semibold">Reward :</h6>
                                    <h6 class="fw-semibold">Description :</h6>
                                </div>
                                <div class="fw-light text-muted">
                                    <h6 class="description-truncate"><?php echo htmlentities($pet->name); ?></h6>
                                    <h6 class="description-truncate"><?php echo htmlentities($pet->breed); ?></h6>
                                    <h6 class="description-truncate"><?php echo htmlentities($pet->age); ?></h6>
                                    <h6 class="description-truncate"><?php echo htmlentities($pet->gender); ?></h6>
                                    <h6 class="description-truncate"><?php echo htmlentities($pet->location); ?></h6>
                                    <h6 class="description-truncate">₱<?php echo htmlentities($pet->reward); ?></h6>
                                    <h6 class="description-truncate">
                                        <?php echo htmlentities($pet->description); ?>
                                    </h6>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- PAGINATION -->
                <nav aria-label="..." class="d-flex justify-content-center py-4">
                    <ul class="pagination pagination-lg">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>

        <!-- </main> -->
    </div>

    <script>
        const Card = () => {
            return `
          <div
             class="pet-card border border-1 border-warning rounded-4 overflow-hidden"
             style="background-color: #ffff"

           >
             <figure class="overflow-hidden">
               <img src="./assets/cat.jpg" alt="pet" class="h-100 w-100" />
             </figure>

             <article
               class="d-flex gap-2 px-2 pt-1 pb-4"

             >
               <div>
                 <h6 class="fw-semibold">Name :</h6>
                 <h6 class="fw-semibold">Breed :</h6>
                 <h6 class="fw-semibold">Age :</h6>
                 <h6 class="fw-semibold">Gender :</h6>
                 <h6 class="fw-semibold">Location :</h6>
                 <h6 class="fw-semibold">Reward :</h6>
                 <h6 class="fw-semibold">Description :</h6>
               </div>
               <div class="fw-light text-muted">
                 <h6>Oroe</h6>
                 <h6>Golden Retriever</h6>
                 <h6>2 yrs old</h6>
                 <h6>Male</h6>
                 <h6>Mamatid</h6>
                 <h6>$10,000</h6>
                 <h6 class="description-truncate">
                   Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                   Deleniti, distinctio.
                 </h6>
               </div>
             </article>
           </div>

        `;
        };

        let displayCard = "";
        for (let i = 0; i < 12; i++) {
            displayCard += Card();
        }
        // document.querySelector(".pets-card-wrapper").innerHTML = displayCard;
    </script>
</body>

</html>