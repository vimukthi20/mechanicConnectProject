<?php
session_start();
include_once "../db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mechanic') {
    header("Location: ../login-form.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM user_details 
          INNER JOIN users ON user_details.user_id = users.id  
          WHERE user_details.user_id = $user_id";
$result = mysqli_query($conn, $query);
$row = $result->fetch_assoc();

// Fetch mechanic services
$services_result = mysqli_query($conn, "SELECT service_name FROM mechanic_services WHERE mechanic_id = $user_id");
$services = [];
while ($service = mysqli_fetch_assoc($services_result)) {
    $services[] = $service['service_name'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mechanic Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
    }

    .profile-card {
      border-radius: 15px;
      overflow: hidden;
      transition: box-shadow 0.3s;
    }

    .profile-card:hover {
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    }

    .profile-image {
      width: 100%;
      border-radius: 10px;
    }

    .info-section h5 {
      font-weight: 600;
    }

    .collapse-header {
      cursor: pointer;
    }

    .service-types-list li::before {
      content: "✔️";
      margin-right: 8px;
      color: green;
    }

    .certificate-image {
      max-width: 100px;
      border-radius: 5px;
      cursor: pointer;
      transition: transform 0.3s;
    }

    .certificate-image:hover {
      transform: scale(1.1);
    }
  </style>
</head>
<body>

<?php include_once 'mechanic-navbar.html' ?>

<div class="container my-5">
  <div class="card profile-card shadow-sm p-4">
    <div class="row g-4">
      <!-- Profile Image -->
      <div class="col-md-4 text-center">
        <img src="./mechanic-profile-images/<?php echo $row['profile_image']; ?>" class="profile-image" alt="Profile Image">
      </div>

      <!-- Profile Details -->
      <div class="col-md-8 info-section">
        <h4><?php echo $row['full_name']; ?></h4>
        <p><i class="fas fa-envelope"></i> <?php echo $row['email']; ?></p>
        <p><i class="fas fa-phone"></i> <?php echo $row['phone']; ?></p>
        <p><i class="fas fa-map-marker-alt"></i> <?php echo $row['address']; ?></p>
        <p><strong>Service Category:</strong> <?php echo $row['service_category']; ?></p>
        <p><strong>Availability:</strong> Weekdays 9am - 6pm</p>
        <p><strong>Pricing:</strong> <?php echo $row['hourly_rate']; ?> $/hour</p>
        <p><strong>Rating:</strong> 4.8 ★</p>
      </div>
    </div>

    <!-- Service Types -->
    <div class="mt-4">
      <h5 class="collapse-header" data-bs-toggle="collapse" href="#servicesCollapse" aria-expanded="true">
        <i class="fas fa-wrench me-2"></i>Service Types <i class="fas fa-angle-down"></i>
      </h5>
      <div class="collapse show" id="servicesCollapse">
        <ul class="list-unstyled mt-2 service-types-list" id="service-types-list">
          <?php foreach ($services as $service): ?>
            <li><?php echo htmlspecialchars($service); ?></li>
          <?php endforeach; ?>
        </ul>
        <button class="btn btn-outline-secondary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#addServiceModal">+ Add Service</button>
      </div>
    </div>

    <!-- Certificates -->
   
      </div>
    </div>
  </div>
</div>

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" id="newServiceInput" class="form-control" placeholder="Enter service name">
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="submitService()">Add</button>
      </div>
    </div>
  </div>
</div>

<!-- Certificate Lightbox Modal -->
<div class="modal fade" id="lightboxModal" tabindex="-1" aria-labelledby="lightboxLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark">
      <div class="modal-body text-center">
        <img src="" id="lightboxImage" class="img-fluid rounded" alt="Certificate">
      </div>
    </div>
  </div>
</div>

<?php include_once 'mechanic-footer.html' ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function submitService() {
  const serviceName = document.getElementById("newServiceInput").value.trim();
  if (serviceName === "") {
    alert("Service name cannot be empty.");
    return;
  }

  fetch("add-service.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ service_name: serviceName })
  })
  .then(res => res.text())
  .then(response => {
    if (response.includes("successfully")) {
      const li = document.createElement("li");
      li.textContent = serviceName;
      document.getElementById("service-types-list").appendChild(li);
      document.getElementById("newServiceInput").value = "";
      bootstrap.Modal.getInstance(document.getElementById("addServiceModal")).hide();
    } else {
      alert("Error: " + response);
    }
  })
  .catch(err => alert("Request failed: " + err));
}

function showCertificate(src) {
  document.getElementById('lightboxImage').src = './mechanic-certificates/' + src;
  const modal = new bootstrap.Modal(document.getElementById('lightboxModal'));
  modal.show();
}
</script>

</body>
</html>
