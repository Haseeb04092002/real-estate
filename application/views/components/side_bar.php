<?php
// $PropertyId = 1;
// $Case = '';
// echo "PropertyId = ".$PropertyId. "<br>";
// echo "Case = ".$Case. "<br>";
// die();


// $urlInformation = ($PropertyId > 0) ? site_url('Properties/AddProperty/'.($Case ? $Case : 'Add').'/'.$PropertyId) : '#';
// $urlFeatures = ($PropertyId > 0) ? site_url('Properties/AddFeatures/'.($Case ? $Case : 'Add').'/'.$PropertyId) : '#';
// $urlImages = ($PropertyId > 0) ? site_url('Properties/AddMedia/'.($Case ? $Case : 'Add').'/'.$PropertyId) : '#';

$urlInformation = site_url('Properties/AddProperty/'.($Case ? $Case : 'Add').'/'.$PropertyId);
$urlPrice = site_url('Properties/AddPrice/'.($Case ? $Case : 'Add').'/'.$PropertyId);
$urlFeatures = site_url('Properties/AddFeatures/'.($Case ? $Case : 'Add').'/'.$PropertyId);
$urlImages = site_url('Properties/AddMedia/'.($Case ? $Case : 'Add').'/'.$PropertyId);


?>


<div class='dashboard'>
  <div class="dashboard-nav">
    <nav class="dashboard-nav-list">
      
      <a href="<?= $urlInformation; ?>" class="dashboard-nav-item">
        <i class="fa fa-file-upload"></i> Information and Price  </a>

      <a href="<?= $urlFeatures; ?>" class="dashboard-nav-item">
        <i class="fa fa-money-check-alt"></i> Features </a>

      <a href="<?= $urlImages; ?>" class="dashboard-nav-item">
        <i class="fa fa-photo-video"></i> Media </a>

      <a href="#" class="dashboard-nav-item">
        <i class="fa fa-cogs"></i> Settings </a>

    </nav>
  </div>
</div>