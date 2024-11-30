<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel - Room Details</title>
  <?php require('admin/inc/links.php'); ?>
  <link rel="stylesheet" href="admin/css/common.css">
  <style>
    .navbar {
      background-color: #343a40;
    }

    .navbar-nav .nav-link {
      color: #fff;
    }

    .navbar-nav .nav-link:hover {
      color: #ffc107;
    }

    .hero-section {
      background: url('images/hotelbilder/deilig.jpeg') center/cover no-repeat;
      height: 50vh;
      position: relative;
    }

    .hero-overlay {
      background: rgba(0, 0, 0, 0.5);
      height: 100%;
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .hero-overlay h1 {
      color: white;
      font-size: 3rem;
      font-weight: bold;
    }

    .room-card img {
      height: 200px;
      object-fit: cover;
    }

    .btn-custom {
      background-color: #343a40;
      color: #fff;
    }

    .btn-custom:hover {
      background-color: #ffc107;
      color: #343a40;
    }
  </style>
</head>

<body class="bg-light">

<?php require('inc/header.php'); ?>

  <!-- Main Section -->
  <div class="hero-section">
    <div class="hero-overlay">
      <h1>Welcome to the Luxury</h1>
    </div>
  </div>

  <!-- Room Details -->
  <div class="container my-5">
    <div class="row">
      <div class="col-md-8">
        <h2 class="fw-bold">Room Features</h2>
        <ul>
          <li>5 Rooms, 3 Bathrooms, 1 Balcony</li>
          <li>4 Sofas, King-Size Beds</li>
          <li>Exquisite Furnishing</li>
        </ul>

        <h3 class="mt-4">Facilities</h3>
        <ul>
          <li>High-speed Wifi</li>
          <li>Television with Premium Channels</li>
          <li>Air Conditioning & Room Heater</li>
        </ul>
      </div>

      <div class="col-md-4">
        <div class="card room-card border-0 shadow">
          <img src="images/hotelbilder/sweet.jpeg" class="card-img-top" alt="Room Image">
          <div class="card-body">
            <h4 class="card-title">Simple Room</h4>
            <p class="card-text">10 Adults, 8 Children</p>
            <h5>5000kr per night</h5>
            <a href="#" class="btn btn-outline-dark btn-sm w-100 mt-2">Book Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require('admin/inc/footer.php'); ?>
</body>

</html>
