<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<?php
  $this->load->view('components/header_meta');
  $this->load->view('components/css_links');
  ?>

</head>
<body>

    <style type="text/css">
        .overlay {
            background: rgba(0, 0, 0, 0.65);
            padding: 40px;
            border-radius: 20px;
            color: #fff;
            text-align: center;
            width: 90%;
            max-width: 750px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }

        h1 {
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .timer {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
        }

        .timer-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px 25px;
            border-radius: 15px;
            font-size: 1.3rem;
            font-weight: 600;
            width: 100px;
        }

        .label {
            font-size: 0.9rem;
            opacity: 0.8;
        }
    </style>
  

    <div class="container-fluid bg-white p-0">
        <?php
        // $this->load->view('components/header', ['ListingPages'=>'no']);
        $heroImage = base_url('assets/images/sydney-hero-img.jpg');
        ?>
    </div>


    <!-- Hero Section -->
    <section class="position-relative d-flex align-items-center justify-content-center text-white text-center"
      style="background: url(<?= $heroImage; ?>); width: 100%; height: 800px; background-repeat: no-repeat; background-size: cover; object-fit: cover; background-position: center;">

      <!-- Overlay -->
      <div class="position-absolute top-0 start-0 w-100 h-100"></div>

      <div class="position-relative container">
        <h3 class="fw-light">Find Your Perfect Fit</h3>
        <h1 class="display-4 fw-bold">Discover Your Dream Home!</h1>
        <p class="lead text-dark">Discover Your Dream Home! We can find you the perfect property & help you locate the home of your dreams.</p>

        <!-- Search Box -->
        <div class="bg-white rounded-1 p-3 mt-2 d-inline-block text-center search-box">
          <h1 class="text-primary">Free Real Estate - <span><img class="img-fluid" src="<?= base_url('assets/images/logo.png'); ?>" alt="Icon" style="width: 90px; height: 70px;"></span>FRE</h1>
        <!-- <p class="lead">We’re launching something incredible! Stay tuned for the official launch.</p> -->
        <span class="badge bg-primary fs-1 h1">COMING SOON</span>

        <!-- Countdown Section -->
        <div class="d-none timer">
            <div class="timer-box">
                <div id="days">00</div>
                <div class="label">Days</div>
            </div>
            <div class="timer-box">
                <div id="hours">00</div>
                <div class="label">Hours</div>
            </div>
            <div class="timer-box">
                <div id="minutes">00</div>
                <div class="label">Minutes</div>
            </div>
            <div class="timer-box">
                <div id="seconds">00</div>
                <div class="label">Seconds</div>
            </div>
        </div>
        </div>
      </div>
    </section>

    <!-- Countdown Script -->
    <script>
        // Set launch date
        const launchDate = new Date("Dec 01, 2025 00:00:00").getTime();

        const timer = setInterval(function() {
            const now = new Date().getTime();
            const distance = launchDate - now;

            document.getElementById("days").innerHTML = Math.floor(distance / (1000 * 60 * 60 * 24));
            document.getElementById("hours").innerHTML = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            document.getElementById("minutes").innerHTML = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            document.getElementById("seconds").innerHTML = Math.floor((distance % (1000 * 60)) / 1000);

            if (distance < 0) {
                clearInterval(timer);
                document.querySelector('.timer').innerHTML = "<h2>We Are Live!</h2>";
            }
        }, 1000);
    </script>

	 
  <?php
  $this->load->view('components/js_links.php');
  ?>

	
</body>
</html>
