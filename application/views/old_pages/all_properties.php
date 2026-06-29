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

    <div class="position-relative container">

        <!-- Search Box -->
        <div class="bg-white rounded-1 p-3 mt-2 d-inline-block text-start search-box">
          <!-- Tabs -->
          <ul class="nav nav-tabs mb-4 justify-content-center">
            <li class="nav-item w-50 text-center">
              <a class="nav-link active" data-bs-toggle="tab" href="#sale">For22 Sale</a>
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


    <!-- Property List Start -->
    <div id="PropertyList" class="container-xxl py-5">
      <div class="container">
        <div class="row g-0 gx-5 align-items-end">
          <div class="col-lg-6">
            <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
              <h1 class="mb-3">All Properties</h1>
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

            <div class="row g-4">
            <?php if (!empty($arrProperties) && is_array($arrProperties)) : 
               foreach ($arrProperties as $key => $value) : 
                  $this->load->view('components/property_card', ['value' => $value, 'UserId' => $UserId]);
               endforeach;
            ?>

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

    <?php
    $this->load->view('components/footer.php');
    $this->load->view('components/js_links.php');
    ?>

    <script>
      document.addEventListener("DOMContentLoaded", function () {

          const allBtn = document.getElementById("AllBtn");
          const saleBtn = document.getElementById("SellBtn");
          const rentBtn = document.getElementById("RentBtn");

          const items = document.querySelectorAll(".property-item");

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
                      item.style.display = "block";
                  } else {
                      if (item.classList.contains(type)) {
                          item.style.display = "block";
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
