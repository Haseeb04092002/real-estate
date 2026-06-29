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
  

  <style>
        body {
            background: url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(4px);
        }

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



    <div class="overlay">
        <h1 class="text-light">Free Real Estate - FRE</h1>
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
