<?php include '../includes/main-wrapper.php' ?>
<?php include '../config/conn.php' ?>


<div class="bg-info-subtle">
    <?php include '../includes/navbar.php' ?>
</div>

<link rel="stylesheet" href="/bc/css/found.css">
<?php

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $intake_date = date('Y-m-d');
    $finder_name = $_POST['finder_name'];
    $pet_name = $_POST['pet_name'];
    $pet_details = $_POST['pet_details'];
    $address = $_POST['address'];
    $pet_type = $_POST['pet_type'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Pet photo handling
    if(isset($_FILES['pet_photo']['tmp_name'])) {
        $pet_photo = $_FILES['pet_photo']['tmp_name'];

        if ($pet_photo) {
            // Read pet photo file content
            $pet_photo_content = file_get_contents($pet_photo);
        } else {
            echo "ERROR: Pet photo is missing.";
        }
    } else {
        echo "ERROR: Pet photo not uploaded.";
    }

   

    // Prepare SQL statement
 // Prepare SQL statement
$sql = "INSERT INTO stray_pets (intake_date, finder_name, pet_name, pet_details, pet_photo, address, pet_type, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters
    $stmt->bind_param("sssssssss", $intake_date, $finder_name, $pet_name, $pet_details, $pet_photo_path, $address, $pet_type, $email, $phone);

    if ($stmt->execute()) {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Success!",
                text: " Form Submitted Successfully!.",
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
echo " ";
}
?>

<!--
<label id="termsCheckboxLabel" for="termsCheckbox">
        <input type="checkbox" id="termsCheckbox" name="termsCheckbox" required>
        I have read and agree to the <a href="/bc/glbl/link_to_terms_of_use.html" target="_blank">Terms</a> and <a href="/bc/glbl/link_to_privacy_policy.html" target="_blank">Privacy Policy</a>.
    </label>
-->


<script>
    function validateForm() {
        var checkbox = document.getElementById("termsCheckbox");
        if (!checkbox.checked) {
            alert("Please agree to the Terms and Privacy Policy before submitting.");
            return false;
        }
        return true;
    }
</script>







<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center">REPORT STRAY</h1>
            </div>
        </div>
    </div>

<div class="container d-flex justify-content-center">
  
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
<div class="formbold-main-wrapper">
  

  <div class="formbold-form-wrapper">
    <form action="https://formbold.com/s/FORM_ID" method="POST">
        <div class="formbold-steps">
            <ul>
                <li class="formbold-step-menu1 active">
                    <span>1</span>
                    Finder Info
                </li>
                <li class="formbold-step-menu2">
                    <span>2</span>
                    Pet Details
                </li>
                <li class="formbold-step-menu3">
                    <span>3</span>
                    Submit
                </li>
            </ul>
        </div>
<!--1ST ROW-->
        <div class="formbold-form-step-1 active">
          <div class="formbold-input-flex">
            <div>
                <label for="firstname" class="formbold-form-label"> Finder name </label>
                <input
                type="text"
                name="finder_name"
                placeholder="Charles C."
                id="firstname"
                class="formbold-form-input"
                required
                />
            </div>
               
            <div>
                <label for="phone" class="formbold-form-label"> Phone Number </label>
                <input type="tel" name="phone" required class="formbold-form-input" placeholder="+6390999828">
            </div>
            
          </div>
<!--2ND ROW-->
          <div class="formbold-input-flex">
           
            <div>
                <label for="lastname" class="formbold-form-label">Address </label>
                <input
                type="text"
                name="address"
                placeholder="Mayapa st.,"
                id="lastname"
                class="formbold-form-input"
                required
                />
            </div>

            <div>
                  <label for="email" class="formbold-form-label"> Email Address </label>
                  <input
                  type="email"
                  name="email"
                  placeholder="example@mail.com"
                  id="email"
                  class="formbold-form-input"
                  required
                  />
              </div>
          </div>

        </div>

        <!--STEP 2-->


        <div class="formbold-form-step-2">
        <div class="formbold-input-flex">


            <div>
                <label for="pet_details" class="formbold-form-label"> Pet Details </label>
                <input
                type="text"
                name="pet_details"
                placeholder="I found inn......"
                id="pet_details"
                class="formbold-form-input"
                required
                />
            </div>


            <div>
                <label for="pet_name" class="formbold-form-label"> Pet Name </label>
                <input
                type="text"
                name="pet_name"
                placeholder="Oggys"
                id="pet_name"
                class="formbold-form-input"
                required
                />
            </div>
            </div>




             <!--2nd row-->

             <div class="formbold-input-flex">

             <div>
                <label for="pet_photo" class="formbold-form-label"> Proof of Photo </label>
                <input type="file" name="pet_photo" required class="formbold-form-input">
            </div>
         

            <div>
    <label for="pet_type_select" class="formbold-form-label"> Pet Type </label>
    <select class="formbold-form-input" name="pet_type" id="pet_type_select" onchange="populateBreeds()" required>
        <option value="">Select Pet Type</option>
        <option value="Dog">Dog</option>
        <option value="Cat">Cat</option>
        <option value="Bird">Bird</option>
        <option value="Hen">Hen</option>
        <option value="Rabbit">Rabbit</option>
        <option value="Other">Other</option>
    </select>
</div>

<div id="breed_dropdown" style="display: none;">
    <label for="breed" class="formbold-form-label"> Breed </label>
    <select id="breed" class="formbold-form-input">
        <option value="">Select Breed</option>
    </select>
</div>

<script>
    function populateBreeds() {
        var petType = document.getElementById('pet_type_select').value;
        var breedDropdown = document.getElementById('breed_dropdown');
        var breedSelect = document.getElementById('breed');

        // Reset breed dropdown
        breedSelect.innerHTML = '<option value="">Select Breed</option>';

        if (petType === 'Dog') {
            var dogBreeds = ['Labrador', 'German Shepherd', 'Golden Retriever', 'Bulldog']; // Add more breeds as needed
            dogBreeds.forEach(function(breed) {
                var option = document.createElement('option');
                option.text = breed;
                breedSelect.add(option);
            });
            breedDropdown.style.display = 'block';
        } else if (petType === 'Cat') {
            var catBreeds = ['Siamese', 'Persian', 'Maine Coon', 'Bengal']; // Add more breeds as needed
            catBreeds.forEach(function(breed) {
                var option = document.createElement('option');
                option.text = breed;
                breedSelect.add(option);
            });
            breedDropdown.style.display = 'block';
        } else {
            breedDropdown.style.display = 'none'; // Hide breed dropdown for other pet types
        }
    }
</script>


            
            </div>
    </div>

        <div class="formbold-form-step-3">
          <div class="formbold-form-confirm">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.
            </p>

            <div>
              <button class="formbold-confirm-btn active" value="Submit">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="11" cy="11" r="10.5" fill="white" stroke="#DDE3EC"/>
                <g clip-path="url(#clip0_1667_1314)">
                <path d="M9.83343 12.8509L15.1954 7.48828L16.0208 8.31311L9.83343 14.5005L6.12109 10.7882L6.94593 9.96336L9.83343 12.8509Z" fill="#536387"/>
                </g>
                </svg>
                Yes! I want it.
              </button>
  
              <a href ="report_stray.php"; class="formbold-confirm-btn">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="11" cy="11" r="10.5" fill="white" stroke="#DDE3EC"/>
                <g clip-path="url(#clip0_1667_1314)">
                <path d="M9.83343 12.8509L15.1954 7.48828L16.0208 8.31311L9.83343 14.5005L6.12109 10.7882L6.94593 9.96336L9.83343 12.8509Z" fill="#536387"/>
                </g>
                </svg>
                No! I don’t want it.
              </a>
            </div>
          </div>
        </div>

        <div class="formbold-form-btn-wrapper">
          <button type="button" class="formbold-back-btn">
            Back
          </button>

          <button type="submit" class="formbold-btn">
              Next Step
          </button>
        </div>
    </form>
  </div>
</div>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
 

  h1{
    margin-top: 5%;
    margin-left: 30%;
    display: flex;
    align-items: center;
    gap: 14px;
    font-weight: 500;
    font-size: 30px;
    line-height: 24px;
    color: #536387;
  }
  .formbold-main-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
  
  }

  .formbold-form-wrapper {
    margin: 0 auto;
    max-width: 550px;
    width: 100%;
    background: white;
  }

  .formbold-steps {
    padding-bottom: 18px;
    margin-bottom: 35px;
    border-bottom: 1px solid #DDE3EC;
  }
  .formbold-steps ul {
    padding: 0;
    margin: 0;
    list-style: none;
    display: flex;
    gap: 40px;
  }
  .formbold-steps li {
    display: flex;
    align-items: center;
    gap: 14px;
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    color: #536387;
  }
  .formbold-steps li span {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #DDE3EC;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    color: #536387;
  }
  .formbold-steps li.active {
    color: #07074D;;
  }
  .formbold-steps li.active span {
    background: #16a34a;
    color: #FFFFFF;
  }
  

  .formbold-input-flex {
    display: flex;
    gap: 20px;
    margin-bottom: 22px;
  }
  .formbold-input-flex > div {
    width: 50%;
  }
  .formbold-form-input {
    width: 100%;
    padding: 13px 22px;
    border-radius: 5px;
    border: 1px solid #DDE3EC;
    background: #FFFFFF;
    font-weight: 500;
    font-size: 16px;
    color: #536387;
    outline: none;
    resize: none;
  }
  .formbold-form-input:focus {
    border-color: #6a64f1;
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
  }
  .formbold-form-label {
    color: #07074D;
    font-weight: 500;
    font-size: 14px;
    line-height: 24px;
    display: block;
    margin-bottom: 10px;
  }

  .formbold-form-confirm {
    border-bottom: 1px solid #DDE3EC;
    padding-bottom: 35px;
  }
  .formbold-form-confirm p {
    font-size: 16px;
    line-height: 24px;
    color: #536387;
    margin-bottom: 22px;
    width: 75%;
  }
  .formbold-form-confirm > div {
    display: flex;
    gap: 15px;
  }

  .formbold-confirm-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #FFFFFF;
    border: 0.5px solid #DDE3EC;
    border-radius: 5px;
    font-size: 16px;
    line-height: 24px;
    color: #536387;
    cursor: pointer;
    padding: 10px 20px;
    transition: all .3s ease-in-out;
  }
  .formbold-confirm-btn {
    box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.12);
  }
  .formbold-confirm-btn.active {
    background: #16a34a;
    color: #FFFFFF;
  }

  .formbold-form-step-1,
  .formbold-form-step-2,
  .formbold-form-step-3 {
    display: none;
  }
  .formbold-form-step-1.active,
  .formbold-form-step-2.active,
  .formbold-form-step-3.active {
    display: block;
  }

  .formbold-form-btn-wrapper {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 25px;
    margin-top: 25px;
  }
  .formbold-back-btn {
    cursor: pointer;
    background: #FFFFFF;
    border: none;
    color: #07074D;
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    display: none;
  }
  .formbold-back-btn.active {
    display: block;
  }
  .formbold-btn {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 16px;
    border-radius: 5px;
    padding: 10px 25px;
    border: none;
    font-weight: 500;
    background-color: #16a34a;
    color: white;
    cursor: pointer;
  }
  .formbold-btn:hover {
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
  }

</style>
<script>
  const stepMenuOne = document.querySelector('.formbold-step-menu1')
  const stepMenuTwo = document.querySelector('.formbold-step-menu2')
  const stepMenuThree = document.querySelector('.formbold-step-menu3')

  const stepOne = document.querySelector('.formbold-form-step-1')
  const stepTwo = document.querySelector('.formbold-form-step-2')
  const stepThree = document.querySelector('.formbold-form-step-3')

  const formSubmitBtn = document.querySelector('.formbold-btn')
  const formBackBtn = document.querySelector('.formbold-back-btn')

  formSubmitBtn.addEventListener("click", function(event){
    event.preventDefault()
    if(stepMenuOne.className == 'formbold-step-menu1 active') {
        event.preventDefault()

        stepMenuOne.classList.remove('active')
        stepMenuTwo.classList.add('active')

        stepOne.classList.remove('active')
        stepTwo.classList.add('active')

        formBackBtn.classList.add('active')
        formBackBtn.addEventListener("click", function (event) {
          event.preventDefault()

          stepMenuOne.classList.add('active')
          stepMenuTwo.classList.remove('active')

          stepOne.classList.add('active')
          stepTwo.classList.remove('active')

          formBackBtn.classList.remove('active')

        })

      } else if(stepMenuTwo.className == 'formbold-step-menu2 active') {
        event.preventDefault()

        stepMenuTwo.classList.remove('active')
        stepMenuThree.classList.add('active')

        stepTwo.classList.remove('active')
        stepThree.classList.add('active')

        formBackBtn.classList.remove('active')
        formSubmitBtn.textContent = ''
      } 
      }
  )
    

  
</script>




<?php include '../includes/main-wrapper-close.php' ?>

<?php include '../includes/footer.php' ?>
