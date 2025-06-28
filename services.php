<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Our Services - FixFlow.lk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    .service-card:hover {
      transform: scale(1.03);
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      transition: 0.3s ease;
    }
    .icon {
      font-size: 2.5rem;
      color: #ffc107;
    }
   
    body {
      scroll-behavior: smooth;
    }

    .section {
      padding: 60px 0;
    }

    .highlight {
      color: #ffc107;
      font-weight: bold;
    }

    .navbar {
      background-color: rgba(255, 255, 255, 0.95);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    }

    .navbar-brand {
      color: #ffc107;
      font-weight: 900;
      font-size: 2rem;
    }

    .navbar-nav .nav-link {
      color: #555;
      font-size: 1.1rem;
      font-weight: 600;
      margin-left: 1rem;
    }

    .navbar-nav .nav-link:hover {
      color: #ffc107;
    }

    .btn-primary {
      background-color: #ffc107;
      color: #fff;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 0.5rem;
      font-weight: 600;
    }

    .btn-primary:hover {
      background-color: #e0a800;
    }

    .footer {
      background-color: #222;
      color: #ccc;
      padding: 40px 0 20px;
    }

    .footer a {
      color: #ccc;
      text-decoration: none;
    }

    .footer a:hover {
      color: #ffc107;
    }

    .footer .social-icons a {
      margin-right: 15px;
      font-size: 1.4rem;
      color: #ffc107;
    }

    .footer-bottom {
      background-color: #111;
      padding: 15px;
      text-align: center;
      color: #aaa;
      font-size: 0.9rem;
    }

    .icon-box {
      display: flex;
      align-items: flex-start;
      gap: 15px;
      margin-bottom: 20px;
    }

    .icon-box i {
      font-size: 2rem;
      color: #ffc107;
    }

    .about-img {
      border-radius: 1rem;
      max-width: 100%;
      height: auto;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .team-img {
      width: 100%;
      border-radius: 1rem;
    }

    .bg-light-yellow {
      background-color: #fffbea;
    }
  
  </style>
</head>
<body>
<br>
<br>
<br>
<br>
<br>
<nav class="navbar navbar-expand-lg bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">FixFlow.lk</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="aboutUs.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="contactUs.php">Contact Us</a></li>
      </ul>
      <a href="login.php" class="btn btn-primary ms-lg-3">Get Started</a>
    </div>
  </div>
</nav>

<main class="container my-5">
  <h1 class="text-center mb-4">Our Services</h1>
  <p class="text-center text-muted mb-5">Explore a variety of home services offered by trusted professionals across Sri Lanka.</p>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card text-center p-4 service-card">
       
        <i class="bi bi-tools icon"></i>
        <h5 class="mt-3">Mechanic Services</h5>
        <p class="text-muted">On-demand vehicle repair and maintenance services at your location.</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center p-4 service-card">
        
        <i class="bi bi-lightning-charge icon"></i>
        <h5 class="mt-3">Electrical Repairs</h5>
        <p class="text-muted">Expert electricians for installations, repairs, and safety checks.</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center p-4 service-card">
        
        <i class="bi bi-droplet-half icon"></i>
        <h5 class="mt-3">Plumbing Services</h5>
        <p class="text-muted">Fix leaks, blockages, and water line issues quickly and professionally.</p>
      </div>
    </div>
  </div>
</main>

<footer class="footer mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h5>About FixFlow.lk</h5>
        <p>Your go-to platform to find trusted home repair professionals across Sri Lanka.</p>
      </div>
      <div class="col-md-2">
        <h5>Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="index.html">Home</a></li>
          <li><a href="aboutUs.php">About</a></li>
          <li><a href="services.php">Services</a></li>
          <li><a href="contactUs.php">Contact</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5>Contact</h5>
        <p><i class="bi bi-envelope"></i> support@fixflow.lk</p>
        <p><i class="bi bi-telephone"></i> +94 77 123 4567</p>
        <p><i class="bi bi-geo-alt"></i> Colombo, Sri Lanka</p>
      </div>
      <div class="col-md-3">
        <h5>Follow Us</h5>
        <div class="social-icons">
          <a href="#"><i class="bi bi-facebook"></i> Facebook</a><br>
          <a href="#"><i class="bi bi-instagram"></i> Instagram</a><br>
          <a href="#"><i class="bi bi-twitter-x"></i> Twitter</a>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom mt-4">
    &copy; 2025 FixFlow.lk | All rights reserved.
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
