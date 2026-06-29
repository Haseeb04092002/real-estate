<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$arrProperties = $this->getlist_model->getFieldsMultipleConditions('tbl_properties','*',"WHERE PropertyTypeId > 0 ORDER BY PropertyId DESC LIMIT 0,12");

$Message_Box = 'd-none';

if (empty($arrProperties)) {
  $Message_Box = 'd-block';
}

$StationId = $this->session->userdata('user_station');

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

  <div class="container-fluid bg-white p-0">

    <?php $this->load->view('components/header', ['ListingPages'=>'no']); ?>


    <!-- Page Container -->
    <div class="container py-5">
      <div class="row gy-4">

        <!-- Left Column: Blog Content -->
        <div class="col-lg-8">
          <h1 class="mb-3">Explore the Hidden Beauty of Northern Valleys</h1>
          <p class="text-muted">Posted on July 31, 2025</p>

          <!-- Featured Image -->
          <img src="<?= base_url('assets/images/property-3.jpg'); ?>" class="img-fluid rounded mb-4" alt="Blog Featured Image">

          <!-- Blog Article -->
          <article class="mb-5">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel libero eu lorem viverra sollicitudin. Aenean accumsan tincidunt purus nec pulvinar. Integer posuere sapien a justo fermentum, nec tincidunt ex vehicula.</p>
            <p>Curabitur eleifend leo et nisl feugiat, nec accumsan est malesuada. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
            <p>Ut vehicula urna non lectus elementum, nec iaculis orci iaculis. Vestibulum id lacinia eros. Morbi at augue nec nulla viverra congue vitae nec nulla.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel libero eu lorem viverra sollicitudin. Aenean accumsan tincidunt purus nec pulvinar. Integer posuere sapien a justo fermentum, nec tincidunt ex vehicula.</p>
            <p>Curabitur eleifend leo et nisl feugiat, nec accumsan est malesuada. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
            <p>Ut vehicula urna non lectus elementum, nec iaculis orci iaculis. Vestibulum id lacinia eros. Morbi at augue nec nulla viverra congue vitae nec nulla.</p>
          </article>

          <!-- Embedded Video -->
          <div class="ratio ratio-16x9 mb-4">
            <iframe src="https://www.youtube.com/embed/y9j-BL5ocW8" title="Real Estate Video Tour" allowfullscreen></iframe>
          </div>

          <!-- Blog Article -->
          <article class="mb-5">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel libero eu lorem viverra sollicitudin. Aenean accumsan tincidunt purus nec pulvinar. Integer posuere sapien a justo fermentum, nec tincidunt ex vehicula.</p>
            <p>Curabitur eleifend leo et nisl feugiat, nec accumsan est malesuada. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
            <p>Ut vehicula urna non lectus elementum, nec iaculis orci iaculis. Vestibulum id lacinia eros. Morbi at augue nec nulla viverra congue vitae nec nulla.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel libero eu lorem viverra sollicitudin. Aenean accumsan tincidunt purus nec pulvinar. Integer posuere sapien a justo fermentum, nec tincidunt ex vehicula.</p>
            <p>Curabitur eleifend leo et nisl feugiat, nec accumsan est malesuada. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
            <p>Ut vehicula urna non lectus elementum, nec iaculis orci iaculis. Vestibulum id lacinia eros. Morbi at augue nec nulla viverra congue vitae nec nulla.</p>
          </article>
        </div>

        <!-- Right Column: Sticky Recommended Blogs -->
        <div class="col-lg-4 p-3">
          <div class="sticky-top" style="top: 80px;">
            <h3 class="mb-4">Recommended Blogs</h3>

            <?php
            $recommended = [
              ['title' => 'Urban Living Guide', 'image' => 'property-1.jpg', 'date' => 'Jul 28, 2025'],
              ['title' => 'Real Estate Trends 2025', 'image' => 'property-2.jpg', 'date' => 'Jul 25, 2025'],
              ['title' => 'Modern Architecture Tips', 'image' => 'property-3.jpg', 'date' => 'Jul 22, 2025'],
            ];
            foreach ($recommended as $blog): ?>
              <div class="card mb-4 p-3 shadow border">
                <img src="<?= base_url('assets/images/'.$blog['image']); ?>" class="card-img-top" alt="...">
                <div class="card-body">
                  <h6 class="card-title"><?= $blog['title']; ?></h6>
                  <p class="text-muted small mb-2"><?= $blog['date']; ?></p>
                  <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Read More</a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

      </div>
    </div>



  </div>

  

	 
  <?php
  $this->load->view('components/footer.php');
  $this->load->view('components/js_links.php');
  ?>

	
</body>
</html>
