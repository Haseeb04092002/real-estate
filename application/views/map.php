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

// Fetch property coordinates from DB
$properties = $this->db->get('tbl_properties')->result();

foreach ($properties as $value) {
  $PropertyId = $value->PropertyId;
  $ImageName = $this->getlist_model->getFieldsMultipleConditions(
      'tbl_documents',
      'FileName',
      "WHERE Reference = 'Properties' AND ReferenceId = '$value->PropertyId'",
      1
  );
  $Bedrooms = $this->getlist_model->getFieldsMultipleConditions(
      'tbl_properties_features',
      'Bedrooms',
      "WHERE PropertyId = '$PropertyId'",
      1
  )??'';
  $Bathrooms = $this->getlist_model->getFieldsMultipleConditions(
      'tbl_properties_features',
      'Bathrooms',
      "WHERE PropertyId = '$PropertyId'",
      1
  )??'';
  $value->Bedrooms = $Bedrooms;
  $value->Bathrooms = $Bathrooms;
  if ($ImageName) {
      $value->ImageURL = base_url('uploads/Properties/'.$value->PropertyId.'/images/'.$ImageName);
  } else {
      $value->ImageURL = base_url('assets/no-image.jpg'); // fallback
  }
  $value->PropertyURL = site_url('Properties/PropertyDetails/' . $value->PropertyId);
  // echo '<br> Image Url = '.$value->ImageURL;
}
unset($p);
// die();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<?php $this->load->view('components/header_meta'); ?>
	<?php $this->load->view('components/css_links'); ?>

</head>
<body>

  <?php $this->load->view('components/header', ['ListingPages'=>'no']); ?>

  <div class="container py-2">
  <nav class="navbar bg-white">
    <div class="container-fluid d-flex justify-content-between align-items-center">

      <!-- Search -->
      <!-- <form class="d-flex" methd="post" action="<?= site_url('Properties/NearByPlaces') ?>"> -->
      <div class="d-flex w-100">
        <input class="form-control w-100 border-0" type="search" placeholder="Karabar, NSW 2620" name="txtInputAddress" id="txtSearchAddress">
        <button id="btnSearchAddress" type="button" class="input-group-text btn btn-dark border-0">
          <!-- <i class="bi bi-search"></i> -->
          search
        </button>
      </div>

      <!-- Buttons -->
      <!-- <div class="d-flex gap-2">
        <button class="btn btn-outline-dark rounded-pill">Property type</button>
        <button class="btn btn-outline-dark rounded-pill">Price</button>
        <button class="btn btn-outline-dark rounded-pill">Bed</button>
        <button class="btn btn-outline-dark rounded-pill">
          <i class="bi bi-sliders"></i> Filters
        </button>
        <button class="btn btn-outline-dark rounded-pill">
          <i class="bi bi-list-task"></i> List
        </button>
      </div> -->
    </div>
  </nav>
</div>

  <div class="p-0">
    <!-- Map -->
    <div id="map" style="width: 100%; height: 500px;"></div>
  </div>

  <?php
    $this->load->view('components/footer');
    $this->load->view('components/js_links');


  ?>

  <!-- Load Google Maps and Places API -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv1FrfWK8d_Z28pT_XtiZW02msCfrC2Rs&libraries=places&callback=initAll" async defer></script>

  <script>
  let map, geocoder, userMarker, autocomplete;

  function initAll() {
    console.log(" initAll triggered");
    
    // Initialize everything together
    initMap();
    initAutocomplete();
  }

  function initMap() {
    console.log(" initMap loaded");
    
    const defaultLocation = { lat: -33.8688, lng: 151.2093 }; // Sydney center

    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 10,
      center: defaultLocation,
    });

    geocoder = new google.maps.Geocoder();
    const infoWindow = new google.maps.InfoWindow({
      disableAutoPan: false,
      closeBoxURL: '',
      isHidden: false
    });

    // Example properties from PHP
    const properties = <?= json_encode($properties) ?>;

    properties.forEach(property => {
      if (property.Latitude && property.Longitude) {
        const marker = new google.maps.Marker({
          position: {
            lat: parseFloat(property.Latitude),
            lng: parseFloat(property.Longitude),
          },
          map,
          title: property.PropertyTitle || "Property",
          icon: { url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png" }
        });
        // console.log(property.ImageURL);
        // Tooltip content (HTML)
        const content = `
          <div style="width:300px">
            <a class="text-decoration-none border-0 text-dark" href="${property.PropertyURL}">
              <img src="${property.ImageURL}" style="width:100%; height:100px; object-fit:cover; border-radius:5px;">
              <h4 class="mt-1 text-decoration-none border-0 text-dark mb-0 pb-0">${property.PropertyTitle}</h4>
              <p class="mt-1 mb-0 pb-0"><strong class="fw-bold pe-1">Price:</strong> ${property.TotalPrice}</p>
              <p class="mt-1 mb-0 pb-0"><strong class="fw-bold pe-1">Area (Sqft):</strong> ${property.CoveredArea}</p>
              <p class="mt-1 mb-0 pb-0"><strong class="fw-bold pe-1">Address:</strong> ${property.MailingAddress}</p>
              <div class="d-flex align-items-center gap-3 mt-1">
                <p class="mb-0 pb-0"><strong class="fw-bold pe-1">Bedrooms:</strong> ${property.Bedrooms}</p>
                <p class="mb-0 pb-0"><strong class="fw-bold pe-1">Bathrooms:</strong> ${property.Bathrooms}</p>
              </div>
            </a>
          </div>
        `;

        // Show info when mouse hovers over the marker
        marker.addListener("mouseover", () => {
          infoWindow.setContent(content);
          infoWindow.open(map, marker);
        });

        // Optional: close when mouse leaves
        // marker.addListener("mouseout", () => {
        //   infoWindow.close();
        // });
      }
    });
  }

  function initAutocomplete() {
    console.log("initAutocomplete loaded");

    const input = document.getElementById('txtSearchAddress');
    autocomplete = new google.maps.places.Autocomplete(input, {
      componentRestrictions: { country: "au" },
      fields: ["address_components", "formatted_address", "geometry"]
    });

    autocomplete.addListener("place_changed", () => {
      const place = autocomplete.getPlace();

      if (!place.geometry) {
        alert("Please select a valid address from the list.");
        return;
      }

      const location = place.geometry.location;
      const lat = location.lat();
      const lng = location.lng();

      // Update map
      map.setCenter(location);
      map.setZoom(14);

      // Add or update marker
      if (userMarker) userMarker.setMap(null);
      userMarker = new google.maps.Marker({
        map: map,
        position: location,
        icon: { url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png" },
        title: place.formatted_address
      });

      console.log("Selected address:", place.formatted_address);
      console.log("Latitude:", lat, "Longitude:", lng);
    });
  }

  // Manual search button (optional)
  function searchAddress() {
    const address = document.getElementById("txtSearchAddress").value.trim();
    if (!address) return alert("Please enter an address.");

    geocoder.geocode({ address: address }, function(results, status) {
      if (status === "OK") {
        const location = results[0].geometry.location;
        map.setCenter(location);
        map.setZoom(14);

        if (userMarker) userMarker.setMap(null);
        userMarker = new google.maps.Marker({
          map: map,
          position: location,
          icon: { url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png" },
          title: "Searched Location"
        });
      } else {
        alert("Geocode failed: " + status);
      }
    });
  }

  // Make functions globally accessible
  window.initAll = initAll;
  window.searchAddress = searchAddress;
  </script>




</body>
</html>
