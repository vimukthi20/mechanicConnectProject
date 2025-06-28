<?php 
session_start();



if (!isset($_SESSION['user_id'])) {
    // Not logged in, redirect to login
    header("Location: ../login-form.php"); // use correct relative path
    exit();
}

// Optional: check if the role matches (for extra protection)
if ($_SESSION['role'] !== 'client') {
    header("Location: ../login-form.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Help & Support</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php  include_once"client-navbar.html"?>
<div class="container mt-5">
  <h2 class="text-center mb-4">Help & Support</h2>

  <!-- FAQ Section -->
  <div class="accordion mb-5" id="faqAccordion">
    <div class="accordion-item">
      <h2 class="accordion-header" id="faq1">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
          How do I book a mechanic?
        </button>
      </h2>
      <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          To book a mechanic, go to the Find Services page, choose your category and location, and click "Book Now" on a provider.
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="faq2">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
          How do I cancel or reschedule a booking?
        </button>
      </h2>
      <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Navigate to "My Bookings", find your upcoming booking, and use the "Cancel" or "Reschedule" button.
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="faq3">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
          What if I have an emergency?
        </button>
      </h2>
      <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Use the "Find Services" page and select only those providers who are marked as "Available Now". Contact them immediately through provided contact details.
        </div>
      </div>
    </div>
  </div>

  <!-- Contact Support Form -->
  <div class="card shadow">
    <div class="card-body">
      <h4 class="mb-4">Still need help? Contact us below:</h4>
      <form>
        <div class="mb-3">
          <label for="name" class="form-label">Your Name</label>
          <input type="text" class="form-control" id="name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Your Email</label>
          <input type="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Your Message</label>
          <textarea class="form-control" id="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
