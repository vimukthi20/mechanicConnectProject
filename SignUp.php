<?php
include_once "db.php";

// Fetch categories
$category_query = "SELECT id, name FROM service_categories ORDER BY name ASC";
$category_result = mysqli_query($conn, $category_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Registration</title>
  <link rel="stylesheet" href="SignUp.css" />
  <style>
    .hidden { display: none; }
    .form-step { display: none; }
    .form-step.active { display: block; }
    .error-msg { color: red; font-size: 0.875em; }
    .buttons { margin-top: 20px; }
  </style>
</head>
<body>
<div class="main-wrapper">
  <div class="image-section"></div>
  <div class="form-container">
    <br>
    <br>
    <br>
    <div class="tabs">
      <button class="tab-btn active" onclick="selectUserType('client')">Client</button>
      <button class="tab-btn" onclick="selectUserType('mechanic')">Mechanic</button>
    </div>

    <!-- CLIENT FORM -->
    <form id="clientForm" class="form-type" action="register.php" method="POST" enctype="multipart/form-data" onsubmit="return validateClientPasswords()">
      <input type="hidden" name="user_type" value="client">

      <!-- Step 1 -->
      <div class="form-step active" id="clientStep1">
        <h2>Client Registration</h2>

        <label for="fname">First Name</label>
        <input type="text" id="fname" name="fname" required />

        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="lname" required />

        <label for="cemail">Email</label>
        <input type="email" id="cemail" name="cemail" required />

        <label for="cphone">Phone Number</label>
        <input type="tel" id="cphone" name="cphone" required />

        <label for="image">Profile Image</label>
        <input type="file" name="image">

        <label for="password">Password</label>
        <input type="password" id="password" name="cpassword" required>

        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <p id="password_error" class="error-msg"></p>

        <div class="buttons">
          <button type="button" class="next-btn" onclick="showClientStep(1)">Next</button>
          <p>Already have an account <a href="login-form.php">Log In</a></p>
          <br>
          <br>
          <br>
        </div>

      </div>

      <!-- Step 2 -->
      <div class="form-step" id="clientStep2">
        <h2>Client Location</h2>
        <label>Province</label>
        <select id="cprovince" name="cprovince" required></select>

        <label>District</label>
        <select id="cdistrict" name="cdistrict" required></select>

        <label>City</label>
        <input type="text" class="city" name="city">

        <label>Full Address</label>
        <input type="text" id="caddress" name="caddress" required />

        <div class="buttons">
          <button type="button" class="prev-btn" onclick="showClientStep(0)">Back</button>
          <button type="submit" class="submit-btn">Register as Client</button>
        </div>
      </div>
    </form>

    <!-- MECHANIC FORM -->
    <form id="mechanicForm" class="form-type hidden" action="register.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="user_type" value="mechanic">

      <!-- Step 1 -->
      <div class="form-step active">
        <h2>Mechanic - Personal Info</h2>
        <label for="mname">Full Name</label>
        <input type="text" id="mname" name="mname" required />

        <label for="memail">Email</label>
        <input type="email" id="memail" name="memail" required />

        <label for="mphone">Phone Number</label>
        <input type="tel" id="mphone" name="mphone" required />

        <label for="image">Profile Image</label>
        <input type="file" name="image" required>

        <label for="mpassword">Password</label>
        <input type="password" id="mpassword" name="mpassword" required />

        <label for="cPassword">Confirm Password</label>
        <input type="password" id="cPassword" name="c_password" required />

        <div class="buttons">
          <div></div>
          <button type="button" class="next-btn" onclick="nextStep()">Next</button>
          
        </div>
        <br>
          <br>
          <br>
      </div>

      <!-- Step 2 -->
      <div class="form-step">
        <h2>Professional Details</h2>
        <label for="service_category">Select Service Category</label>
        <select name="service_category" id="service_category" required>
          <option value="">-- Select Category --</option>
          <?php while ($row = mysqli_fetch_assoc($category_result)): ?>
           <option value="<?= htmlspecialchars($row['name']); ?>"><?= htmlspecialchars($row['name']); ?></option>

          <?php endwhile; ?>
        </select>

        <label for="mexperience">Years of Experience</label>
        <input type="number" id="mexperience" name="mexperience" min="0" required />

        

        <label for="mrate">Hourly Rate ($)</label>
        <input type="number" id="mrate" name="mrate" min="0" required />

        <div class="buttons">
          <button type="button" class="prev-btn" onclick="prevStep()">Back</button>
          <button type="button" class="next-btn" onclick="nextStep()">Next</button>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="form-step">
        <h2>Location & Availability</h2>

        <label>Province</label>
        <select id="mprovince" name="mprovince" required></select>

        <label>District</label>
        <select id="mdistrict" name="mdistrict" required></select>

        <label>City</label>
        <input type="text" name="mcity">

        <label for="maddress"> Address</label>
        <input type="text" id="maddress" name="address" required />

      

        <input type="hidden" id="mlatitude" name="mlatitude">
        <input type="hidden" id="mlongitude" name="mlongitude">

        <div class="buttons">
          <button type="button" class="prev-btn" onclick="prevStep()">Back</button>
          <button type="submit" class="submit-btn">Register as Mechanic</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
const locationData = {
   "Central": ["Kandy", "Matale", "Nuwara Eliya"],
      "Eastern": ["Ampara", "Batticaloa", "Trincomalee"],
      "Northern": ["Jaffna", "Kilinochchi", "Mannar", "Vavuniya", "Mullaitivu"],
      "North Central": ["Anuradhapura", "Polonnaruwa"],
      "North Western": ["Kurunegala", "Puttalam"],
      "Sabaragamuwa": ["Ratnapura", "Kegalle"],
      "Southern": ["Galle", "Matara", "Hambantota"],
      "Uva": ["Badulla", "Monaragala"],
      "Western": ["Colombo", "Gampaha", "Kalutara"]
};

function populateSelect(select, options) {
  select.innerHTML = "<option value=''>-- Select --</option>";
  options.forEach(opt => {
    const option = document.createElement("option");
    option.value = opt;
    option.textContent = opt;
    select.appendChild(option);
  });
}

function setupLocationDropdowns(prefix) {
  const province = document.getElementById(prefix + "province");
  const district = document.getElementById(prefix + "district");
  const city = document.getElementById(prefix + "city");

  populateSelect(province, Object.keys(locationData));

  province.addEventListener("change", function () {
    const districts = locationData[this.value] || [];

    populateSelect(district, districts);
    city.innerHTML = "<option value=''>-- Select --</option>";
  });

  district.addEventListener("change", function () {
    const selectedProvince = province.value;
    const cities = locationData[selectedProvince]?.[this.value] || [];
    populateSelect(city, cities);
  });
}

document.addEventListener("DOMContentLoaded", () => {
  setupLocationDropdowns("c");
  setupLocationDropdowns("m");
});

const tabButtons = document.querySelectorAll(".tab-btn");
const clientForm = document.getElementById("clientForm");
const mechanicForm = document.getElementById("mechanicForm");
const mechanicSteps = document.querySelectorAll("#mechanicForm .form-step");
let currentStep = 0;

function selectUserType(type) {
  tabButtons.forEach(btn => btn.classList.remove("active"));
  if (type === 'client') {
    clientForm.classList.remove("hidden");
    mechanicForm.classList.add("hidden");
    tabButtons[0].classList.add("active");
  } else {
    clientForm.classList.add("hidden");
    mechanicForm.classList.remove("hidden");
    tabButtons[1].classList.add("active");
    showStep(0);
  }
}

function showClientStep(step) {
  document.getElementById("clientStep1").classList.toggle("active", step === 0);
  document.getElementById("clientStep2").classList.toggle("active", step === 1);
}

function showStep(step) {
  mechanicSteps.forEach((s, i) => s.classList.toggle("active", i === step));
  currentStep = step;
}

function nextStep() {
  if (validateMechanicStep(currentStep)) {
    showStep(currentStep + 1);
  }
}

function prevStep() {
  if (currentStep > 0) showStep(currentStep - 1);
}

function validateClientPasswords() {
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirm_password").value;
  const errorMsg = document.getElementById("password_error");

  if (password.length < 6) {
    errorMsg.textContent = "Password must be at least 6 characters.";
    return false;
  }
  if (password !== confirmPassword) {
    errorMsg.textContent = "Passwords do not match!";
    return false;
  }
  errorMsg.textContent = "";
  return true;
}

function validateMechanicStep(step) {
  let isValid = true;
  const stepElement = mechanicSteps[step];
  const inputs = stepElement.querySelectorAll("input, select");

  inputs.forEach(input => {
    const errorEl = input.nextElementSibling;
    if (errorEl && errorEl.classList.contains("error-msg")) {
      errorEl.remove();
    }

    if (!input.value) {
      showError(input, "This field is required.");
      isValid = false;
    } else if (input.type === "email" && !/^\S+@\S+\.\S+$/.test(input.value)) {
      showError(input, "Enter a valid email.");
      isValid = false;
    } else if (input.type === "tel" && !/^\d{10,15}$/.test(input.value)) {
      showError(input, "Enter a valid phone number.");
      isValid = false;
    } else if (input.name === "mpassword" && input.value.length < 6) {
      showError(input, "Password must be at least 6 characters.");
      isValid = false;
    } else if (input.name === "c_password") {
      const password = document.getElementById("mpassword").value;
      if (input.value !== password) {
        showError(input, "Passwords do not match.");
        isValid = false;
      }
    } else if (input.type === "number" && input.value < 0) {
      showError(input, "Enter a positive number.");
      isValid = false;
    }
  });

  return isValid;
}

function showError(input, message) {
  const error = document.createElement("div");
  error.classList.add("error-msg");
  error.textContent = message;
  input.parentNode.insertBefore(error, input.nextSibling);
}




function updateSkillTags() {
  skillTagsContainer.innerHTML = "";
  skills.forEach(skill => {
    const tag = document.createElement("div");
    tag.className = "skill-tag";
    tag.innerHTML = `${skill} <span onclick="removeSkill('${skill}')">&times;</span>`;
    skillTagsContainer.appendChild(tag);
  });
  hiddenSkillsInput.value = skills.join(", ");
}

function removeSkill(skill) {
  skills = skills.filter(s => s !== skill);
  updateSkillTags();
}
</script>
</body>
</html>
