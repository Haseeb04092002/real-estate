<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_filter = $is_filter??false;
if (!empty($FilteredProperties)) {
  $arrProperties = $FilteredProperties??'';
}
else{
  $arrProperties = $Properties??'';
}

$StationId = $this->session->userdata('user_station');

$UserId = $this->session->userdata('user_id')??'';
// echo "<br>user_id = " . $this->session->userdata('user_id');
// echo "<br>user_name = " . $this->session->userdata('user_name');

// die();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <?php $this->load->view('components/header_meta'); ?>
  <?php $this->load->view('components/css_links'); ?>

</head>
<body>

  <div class="container-fluid bg-white p-0">
    <?php
    $this->load->view('components/header', ['ListingPages'=>'no']);
    $heroImage = base_url('assets/images/sydney-hero-img.jpg');
    ?>

    
    <?php
    $this->load->view('components/filter_modal_2', ['StationId',$StationId]);
    ?>

  </div>

    <style type="text/css">
  .search-box {
    min-width: 900px;
  }

  .search-input {
    border: none;
    outline: none;
  }

  .nav-tabs .nav-link {
    border: none;
    color: #000;
    font-size: 1.1rem;
  }

  .nav-tabs .nav-link.active {
    border-bottom: 3px solid #0d6efd !important;
    font-weight: bold;
    color: #155DFC !important;
  }

  /* ✅ Responsiveness */
  @media (max-width: 991px) {
    .search-box {
      min-width: 100%;
    }

    .tab-content .d-flex {
      flex-wrap: wrap !important;
      gap: 10px !important;
    }

    .tab-content .input-group {
      width: 100% !important;
    }

    .tab-content button,
    .tab-content a {
      flex: 1 1 48%;
    }
  }

  @media (max-width: 576px) {
    section {
      height: auto !important;
      padding: 60px 15px;
    }

    .search-box {
      padding: 15px !important;
      min-width: 100%;
    }

    .tab-content button,
    .tab-content a {
      flex: 1 1 100%;
    }

    h1.display-4 {
      font-size: 1.8rem !important;
    }

    h3 {
      font-size: 1.1rem !important;
    }

    p.lead {
      font-size: 0.9rem !important;
    }
  }
</style>

    <!-- Hero Section -->
    <section class="position-relative d-flex align-items-center justify-content-center text-white text-center"
      style="background: url(<?= $heroImage; ?>); width: 100%; height: 700px; background-repeat: no-repeat; background-size: cover; object-fit: cover; background-position: center;">

      <!-- Overlay -->
      <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.4));"></div>

      <div class="position-relative container">
        <h3 class="fw-light">Find Your Perfect Fit</h3>
        <h1 class="display-4 fw-bold">Discover Your Dream Home!</h1>
        <p class="lead text-light">Discover Your Dream Home! We can find you the perfect property & help you locate the home of your dreams.</p>

        <!-- Search Box -->
        <div class="bg-white rounded-1 p-3 mt-2 d-inline-block text-start search-box">
          <!-- Tabs -->
          <ul class="nav nav-tabs mb-4 justify-content-center">
            <li class="nav-item w-50 text-center">
              <a class="nav-link active" data-bs-toggle="tab" href="#sale">For Sale</a>
            </li>
            <li class="nav-item w-50 text-center">
              <a class="nav-link" data-bs-toggle="tab" href="#rent">For Rent</a>
            </li>
          </ul>

          <!-- Tab Content -->
          <div class="tab-content">
            <!-- For Sale -->
            <div class="tab-pane active" id="sale">
              <div class="d-flex align-items-center gap-3 flex-nowrap">
                <div class="input-group input-group-lg border rounded-pill px-3 flex-grow-1">
                  <span class="input-group-text border-0 bg-white">
                    <i class="fa fa-search"></i>
                  </span>
                  <input id="propertySearch" type="text" class="form-control border-0 search-input"
                    placeholder="Select suburb, postcode, or states">
                </div>
                <button class="btn1 btn-light border rounded-pill btn-lg" data-bs-toggle="modal" data-bs-target="#filterModal">Filters</button>
                <button class="btn btn-primary rounded-pill btn-lg">Search</button>
                <a class="btn btn-primary rounded-pill btn-lg" href="<?= site_url('Properties/map'); ?>">Maps</a>
              </div>
            </div>

            <!-- For Rent -->
            <div class="tab-pane" id="rent">
              <div class="d-flex align-items-center gap-3 flex-nowrap">
                <div class="input-group input-group-lg border rounded-pill px-3 flex-grow-1">
                  <span class="input-group-text border-0 bg-white">
                    <i class="fa fa-search"></i>
                  </span>
                  <input type="text" class="form-control border-0 search-input fs-6"
                    placeholder="Select suburb, postcode, or states">
                </div>
                <button class="btn1 btn-light border rounded-pill btn-lg" data-bs-toggle="modal" data-bs-target="#filterModal">Filters</button>
                <button class="btn btn-primary rounded-pill btn-lg">Search</button>
                <button class="btn btn-primary rounded-pill btn-lg" data-bs-toggle="modal" data-bs-target="#mapModal">Maps</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- Property List Start -->
    <div id="PropertyList" class="container-xxl py-5">
      <div class="container">
        <div class="row g-0 gx-5 align-items-end">
          <div class="col-lg-6">
            <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
              <h1 class="mb-3">Feature Properties</h1>
            </div>
          </div>
          <div id="sell-rent-tabs" class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s">
            <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
              <li class="nav-item me-2">
                <a id="AllBtn" class="btn btn-outline-primary" data-bs-toggle="pill" href="#tab-2">All</a>
              </li>
              <li class="nav-item me-2">
                <a id="SellBtn" class="btn btn-outline-primary" data-bs-toggle="pill" href="#tab-2">For Sale</a>
              </li>
              <li class="nav-item me-0">
                <a id="RentBtn" class="btn btn-outline-primary" data-bs-toggle="pill" href="#tab-3">For Rent</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="tab-content">
          <div id="tab-1" class="tab-pane fade show p-0 active">

            <div class="row g-4 d-flex flex-wrap w-100 m-0">
              <?php if (!empty($arrProperties) && is_array($arrProperties)) : 
               foreach ($arrProperties as $key => $value) : 
                  $this->load->view('components/property_card', ['value' => $value, 'UserId' => $UserId]);
               endforeach;
              ?>

              <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                <a class="btn btn-primary py-3 px-5" href="<?= site_url('Properties/all_properties') ?>">Browse More Property</a>
              </div>

            <?php else: ?>
              <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                <div class="alert alert-warning py-4 fs-5" role="alert">
                  <i class="fa fa-info-circle me-2"></i> No property advertisements found.
                </div>
              </div>
            <?php endif; ?>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Property News -->
    <div class="container py-5">
      <div class="text-center mx-auto mb-5">
        <h1 class="mb-3">Latest Property News</h1>
        <p>Publish the best of your client testimonials and let the world know what a great agent or real estate agency you are. Testimonials build trust.</p>
      </div>
      
      <style>
        /* Position buttons vertically centered */
        .swiper-button-next, .swiper-button-prev {
          width: 40px;
          height: 40px;
          top: 50%;
          transform: translateY(-50%);
          box-shadow: 0 2px 6px rgba(0,0,0,0.15);
          background-color: #0d6efd; /* Bootstrap primary */
          color: #fff !important;
        }

        /* Remove Swiper default arrow text */
        .swiper-button-next::after,
        .swiper-button-prev::after {
          font-size: 16px; /* Adjust icon size */
          font-weight: bold;
        }

        /* Hover effect */
        .swiper-button-next:hover, .swiper-button-prev:hover {
          background-color: #0d6efd; /* Bootstrap primary */
          color: #fff !important;
        }
      </style>

      <!-- Swiper -->
      <div class="swiper mySwiper">
        <div class="swiper-wrapper p-2">
            <?php
            // Use the $Blogs variable from the controller
            $blog_posts = isset($Blogs) ? $Blogs : [];
            foreach ($blog_posts as $post):
              $title = htmlspecialchars($post->Title);
              $description = htmlspecialchars($post->Description);
              $date = date('F j, Y', strtotime($post->CreatedAt));
              
              // If the dummy image starts with "property-", we know it's a local dummy image. Otherwise it's uploaded.
              $imageSrc = strpos($post->ImageName, 'property-') === 0 
                  ? base_url('assets/images/' . $post->ImageName) 
                  : base_url('uploads/blogs/' . $post->ImageName);
            ?>
            <div class="swiper-slide">
              <!-- Blog Card -->
              <div class="card border border-dark rounded-4 h-100" style="min-height: 390px; max-height: 390px;">
                <img src="<?= $imageSrc ?>" class="card-img-top rounded-top-4" style="height: 200px; object-fit: cover;" alt="Blog Image">
                <div class="card-body d-flex flex-column">
                  <h6 class="card-title text-primary fw-semibold mb-1"><?= $title; ?></h6>
                  <p class="small text-muted mb-1">Posted on: <?= $date; ?></p>
                  <p class="card-text small text-dark flex-grow-1">
                    <?= $description; ?>
                  </p>
                  <div class="mt-2">
                    <a href="<?= site_url('Properties/news_details'); ?>" class="btn btn-sm btn-outline-primary rounded-pill mb-3">Read More</a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <!-- Navigation buttons -->
        <div class="swiper-button-next btn btn-primary text-dark p-2 rounded-circle border-0 d-flex align-items-center justify-content-center"></div>
        <div class="swiper-button-prev btn btn-primary text-dark p-2 rounded-circle border-0 d-flex align-items-center justify-content-center"></div>
      </div>
    </div>

    <!-- Call to Action Start -->
     <div id="Contact" class="container-xxl py-5">
      <div class="container">
        <div class="bg-light rounded p-3">
          <div class="bg-white rounded p-4" style="border: 1px dashed rgba(0, 185, 142, .3)">
            <div class="row g-5 align-items-center">
              <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                <img class="img-fluid rounded w-100" src="<?= base_url('assets/images/call-to-action.jpg'); ?>" alt="">
              </div>
              <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                <div class="mb-4">
                  <h1 class="mb-3">Contact Us</h1>
                  <p>Contact us today if you’d like to know more about how we help buy, sell or rent your home.</p>
                </div>
                <a href="<?= site_url('Properties/contact'); ?>" class="btn btn-dark py-3 px-4 mb-2">
                  <i class="fa fa-calendar-alt me-2"></i>Get Appoinment </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
    $this->load->view('components/footer.php');
    $this->load->view('components/js_links.php');
    ?>

    <script>
      document.addEventListener("DOMContentLoaded", function () {

          const allBtn = document.getElementById("AllBtn");
          const saleBtn = document.getElementById("SellBtn");
          const rentBtn = document.getElementById("RentBtn");

          const items = document.querySelectorAll(".property-item-box");

          // Show all items by default
          filterProperties("All");

          // Add event listeners
          allBtn.addEventListener("click", function () {
              filterProperties("All");
          });

          saleBtn.addEventListener("click", function () {
              filterProperties("Sale");
          });

          rentBtn.addEventListener("click", function () {
              filterProperties("Rent");
          });

          function filterProperties(type) {
              items.forEach(item => {
                  if (type === "All") {
                      item.style.display = "";
                  } else {
                      if (item.classList.contains(type)) {
                          item.style.display = "";
                      } else {
                          item.style.display = "none";
                      }
                  }
              });

              // Toggle active button styling
              [allBtn, saleBtn, rentBtn].forEach(btn => btn.classList.remove("active"));
              if (type === "All") allBtn.classList.add("active");
              if (type === "Sale") saleBtn.classList.add("active");
              if (type === "Rent") rentBtn.classList.add("active");
          }
      });
      </script>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const searchBox = document.getElementById("propertySearch");
        const applyBtn = document.getElementById("applyFilters");
        const properties = document.querySelectorAll(".property-item-box");

        function applyFilters() {
            let query = searchBox ? searchBox.value.toLowerCase().trim() : "";
            console.log(query);
            let selectedTypes = Array.from(document.querySelectorAll('input[name="propertyType[]"]:checked'))
                                     .map(el => el.value); // now values are numeric IDs

            let minPrice = document.querySelector('input[name="txtMinPrice"]')?.value.trim();
            let maxPrice = document.querySelector('input[name="txtMaxPrice"]')?.value.trim();
            let bedrooms = document.querySelector('select[name="txtBedrooms"]')?.value;
            let bathrooms = document.querySelector('select[name="txtBathrooms"]')?.value;
            let state = document.querySelector('input[name="txtState"]')?.value.toLowerCase().trim();
            let suburb = document.querySelector('input[name="txtSuburb"]')?.value.toLowerCase().trim();

            properties.forEach(card => {
                let show = true;

                let searchable = card.dataset.search || "";
                let price = parseInt(card.dataset.price) || 0;
                let cardBedrooms = parseInt(card.dataset.bedrooms) || 0;
                let cardBathrooms = parseInt(card.dataset.bathrooms) || 0;
                let cardType = card.dataset.type;  // numeric ID now
                let cardState = card.dataset.state || "";
                let cardSuburb = card.dataset.suburb || "";

                // Keyword search
                if (query && !searchable.includes(query)) show = false;

                // Types
                if (selectedTypes.length > 0 && !selectedTypes.includes(cardType)) show = false;

                // Price
                if (minPrice && price < parseInt(minPrice)) show = false;
                if (maxPrice && price > parseInt(maxPrice)) show = false;

                // Bedrooms / Bathrooms
                if (bedrooms && bedrooms !== "Select" && cardBedrooms < parseInt(bedrooms)) show = false;
                if (bathrooms && bathrooms !== "Select" && cardBathrooms < parseInt(bathrooms)) show = false;

                // Location
                if (state && !cardState.includes(state)) show = false;
                if (suburb && !cardSuburb.includes(suburb)) show = false;

                card.style.display = show ? "" : "none";
            });
        }

        if (searchBox) {
            searchBox.addEventListener("keyup", applyFilters);
        }

        if (applyBtn) {
            applyBtn.addEventListener("click", applyFilters);
        }
      });

    </script>



    <!-- Swiper JS Initialization -->
    <script>
      const swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 30,
        loop: true,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false, // keeps autoplay after manual nav
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        breakpoints: {
          0: { slidesPerView: 1 },
          576: { slidesPerView: 2 },
          768: { slidesPerView: 3 },
          992: { slidesPerView: 4 }
        }
      });

      // Pause on hover
      const swiperEl = document.querySelector('.mySwiper');
      swiperEl.addEventListener('mouseenter', () => swiper.autoplay.stop());
      swiperEl.addEventListener('mouseleave', () => swiper.autoplay.start());
    </script>

    <script type="text/javascript">
      tippy('.tooltipBtn');
      // Function to generate tooltip content with separate CSS classes for value and unit
      function generateTooltipContent(value, unit) {
        value = parseFloat(value);
        // if (isNaN(value)) {
        //   return "Invalid Value";
        // }

        let kanal, marla, sqft, sqyd;
        let content = '';

        // Conversion logic based on the unit
        switch (unit) {
          case "Sqft":
            kanal = value / 5445;
            marla = value / 225;
            sqyd = value * 0.11111;
            content = `
              <span class="tooltip-unit">Kanal = </span><span class="tooltip-value">${kanal.toFixed(2)}</span><br>
              <span class="tooltip-unit">Marla = </span><span class="tooltip-value">${marla.toFixed(2)}</span><br>
              <span class="tooltip-unit">Sqyd = </span><span class="tooltip-value">${sqyd.toFixed(2)}</span>`;
            break;
          case "Kanal":
            sqft = value * 5445;
            marla = value * 20;
            sqyd = value * 605;
            content = `
              <span class="tooltip-unit">Sqft = </span><span class="tooltip-value">${sqft.toFixed(2)}</span><br>
              <span class="tooltip-unit">Marla = </span><span class="tooltip-value">${marla.toFixed(2)}</span><br>
              <span class="tooltip-unit">Sqyd = </span><span class="tooltip-value">${sqyd.toFixed(2)}</span>`;
            break;
          case "Marla":
            kanal = value * 0.05;
            sqft = value * 272.25;
            sqyd = value * 30.25;
            content = `
              <span class="tooltip-unit">Kanal = </span><span class="tooltip-value">${kanal.toFixed(2)}</span><br>
              <span class="tooltip-unit">Sqft = </span><span class="tooltip-value">${sqft.toFixed(2)}</span><br>
              <span class="tooltip-unit">Sqyd = </span><span class="tooltip-value">${sqyd.toFixed(2)}</span>`;
            break;
          case "Sqyd":
            kanal = value * 0.00165;
            marla = value * 0.04;
            sqft = value * 9;
            content = `
              <span class="tooltip-unit">Sqft = </span><span class="tooltip-value">${sqft.toFixed(2)}</span><br>
              <span class="tooltip-unit">Marla = </span><span class="tooltip-value">${marla.toFixed(2)}</span><br>
              <span class="tooltip-unit">Kanal = </span><span class="tooltip-value">${kanal.toFixed(2)}</span>`;
            break;
          default:
            return "Invalid Unit";
        }

        // Return the formatted content with separate classes
        return content;
      }

      // Initialize tooltips for each element with .tooltipBtn class
      const buttons = document.querySelectorAll('.tooltipBtn');
      buttons.forEach(button => {
        const value = button.getAttribute("value");
        const unit = button.getAttribute("data-unit");

        tippy(button, {
            content: generateTooltipContent(value, unit),
            allowHTML: true,
            interactive: true,
            placement: 'bottom',
            theme: 'own',
            followCursor: 'horizontal',
            duration: [200, 500],
            arrow: false
        });
      });

    </script>
  
</body>
</html>
