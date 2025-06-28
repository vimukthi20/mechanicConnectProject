<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - FixFlow.lk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

  <style>
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

<!-- Navbar -->
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

<!-- Main Content -->
<main class="container section" style="padding-top: 100px;">
  <h1 class="text-center mb-5" data-aos="fade-down">About <span class="highlight">FixFlow.lk</span></h1>

  <div class="row align-items-center mb-5">
    <div class="col-md-6" data-aos="fade-right">
      <img src="images/about1.jpg" alt="Mechanic Workshop" class="about-img">
    </div>
    <div class="col-md-6" data-aos="fade-left">
      <h4>Our Mission</h4>
      <p>
        FixFlow.lk is built to bridge the gap between clients and trusted mechanics, electricians, plumbers, and more across Sri Lanka. We believe in delivering trustworthy, transparent, and efficient services with a digital-first approach.
      </p>
    </div>
  </div>

  <div class="row align-items-center mb-5 flex-md-row-reverse">
    <div class="col-md-6" data-aos="fade-left">
      <img src="images/about2.jpg" alt="Technician at work" class="about-img">
    </div>
    <div class="col-md-6" data-aos="fade-right">
      <h4>Why Choose Us?</h4>
      <div class="icon-box">
        <i class="bi bi-patch-check-fill"></i>
        <div><strong>Verified Professionals:</strong> All providers are background-checked and reviewed by clients.</div>
      </div>
      <div class="icon-box">
        <i class="bi bi-calendar-check-fill"></i>
        <div><strong>Real-Time Scheduling:</strong> Book and reschedule services with just a few clicks.</div>
      </div>
      <div class="icon-box">
        <i class="bi bi-shield-lock-fill"></i>
        <div><strong>Secure & Reliable:</strong> We prioritize safety, quality, and transparency.</div>
      </div>
    </div>
  </div>

  <div class="row mt-5" data-aos="fade-up">
    <div class="col-md-12 text-center mb-4">
      <h3>Meet Our Founders</h3>
      <p class="text-muted">A passionate team of engineers & developers who care about making life easier.</p>
    </div>

    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
      <img src="images/about3.jpg"  class="team-img mb-3" alt="Founder 1">
      <h5>Kasun Perera</h5>
      <p>Co-Founder / Backend Developer</p>
    </div>
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
      <img src="images/about4.jpg" class="team-img mb-3" alt="Founder 2">
      <h5>Nimasha Jayasinghe</h5>
      <p>Co-Founder / UI Designer</p>
    </div>
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
      <img src="images/about5.jpg"  class="team-img mb-3" alt="Founder 3">
      <h5>Tharindu Silva</h5>
      <p>Marketing & Customer Experience</p>
    </div>
  </div>
</main>

<!-- Footer -->
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

<script>
  AOS.init({ duration: 1000 });
</script>

</body>
</html>
