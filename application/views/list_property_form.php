<?php
$CompanyId        = '3';
$StationId = $this->session->userdata('user_station');
$CompanyName      = $this->getlist_model->getFieldsMultipleConditions("tbl_companies","CompanyName","WHERE CompanyId = $CompanyId",1);

$lnkInformation = 'loadlink="Properties/AddProperty/'.$Case.'/'.$PropertyId.'"';
$lnkPricing     = 'loadlink="Properties/AddPrice/'.$Case.'/'.$PropertyId.'"';
$lnkFeatures    = 'loadlink="Properties/AddFeatures/'.$Case.'/'.$PropertyId.'"';
$lnkImages      = 'loadlink="Properties/AddMedia/'.$Case.'/'.$PropertyId.'"';
$lnkDocuments   = 'loadlink="Properties/AddDocuments/'.$Case.'/'.$PropertyId.'"';
$lnkPreview     = 'loadlink="Properties/PreviewProperty/'.$Case.'/'.$PropertyId.'"';

if ($SubView == 'features') {
    $loadURL = "Properties/AddFeatures/$Case/$PropertyId";
} else if ($SubView == 'pricing') {
    $loadURL = "Properties/AddPrice/$Case/$PropertyId";
} else if ($SubView == 'media') {
    $loadURL = "Properties/AddMedia/$Case/$PropertyId";
} else if ($SubView == 'documents') {
    $loadURL = "Properties/AddDocuments/$Case/$PropertyId";
} else if ($SubView == 'preview') {
    $loadURL = "Properties/PreviewProperty/$Case/$PropertyId";
} else {
    $loadURL = "Properties/AddProperty/$Case/$PropertyId";
}

$activeInformation = ($SubView == 'information' || $SubView == '') ? 'active' : '';
$activePricing = ($SubView == 'pricing') ? 'active' : '';
$activeFeatures = ($SubView == 'features') ? 'active' : '';
$activeImages = ($SubView == 'media') ? 'active' : '';
$activeDocuments = ($SubView == 'documents') ? 'active' : '';
$activePreview = ($SubView == 'preview') ? 'active' : '';

$btnInformation = '<button type="button" class="sidebar-link dashboard-nav-item actLoadLink '.$activeInformation.'" id="btnInformation" '.$lnkInformation.'><i class="fa fa-info-circle icon-left"></i><span>Basic Information</span></button>';

$btnPricing = '<button type="button" class="sidebar-link dashboard-nav-item actLoadLink '.$activePricing.'" id="btnPricing" '.$lnkPricing.'><i class="fa fa-tags icon-left"></i><span>Pricing</span></button>';

$btnFeatures  = '<button type="button" class="sidebar-link dashboard-nav-item actLoadLink '.$activeFeatures.'" id="btnFeatures" '.$lnkFeatures.'><i class="fa fa-money-check-alt icon-left"></i><span>Features</span></button>';

$btnImages = '<button type="button" class="sidebar-link dashboard-nav-item actLoadLink '.$activeImages.'" id="btnImages" '.$lnkImages.'><i class="fa fa-photo-video icon-left"></i><span>Media</span></button>';

$PropertyTypeId = 0;
if (isset($PropertyId) && $PropertyId > 0) {
    $prop = $this->db->get_where('tbl_properties', ['PropertyId' => $PropertyId])->row();
    if ($prop) $PropertyTypeId = $prop->PropertyTypeId;
}

$DocTypesCount = 0;
if (isset($this->getlist_model)) {
    $docTypesData = $this->getlist_model->getFieldsMultipleConditions('tbl_property_document_types', '*', "WHERE PropertyType='All' OR PropertyType='$PropertyTypeId' OR PropertyType='' OR PropertyType IS NULL", 2);
    if(is_array($docTypesData)) $DocTypesCount = count($docTypesData);
    elseif(is_object($docTypesData)) $DocTypesCount = 1;
}

$btnDocuments = '';
if ($DocTypesCount > 0) {
    $btnDocuments = '<button type="button" class="sidebar-link dashboard-nav-item actLoadLink '.$activeDocuments.'" id="btnDocuments" '.$lnkDocuments.'><i class="fa fa-file-alt icon-left"></i><span>Documents</span></button>';
}

$btnPreview = '<button type="button" class="sidebar-link dashboard-nav-item actLoadLink '.$activePreview.'" id="btnPreview" '.$lnkPreview.'><i class="fa fa-eye icon-left"></i><span>Preview</span></button>';

$this->load->view('components/css_links');

?>

    <style>
        :root {
            --light-bg: #f5f7fb;
        }

        body {
            background: var(--light-bg);
            font-family: 'Inter', sans-serif;
        }

        .dashboard-container {
            padding: 30px;
        }

        @media(max-width:768px) {
            .dashboard-container { padding: 15px; }
        }

        .dashboard-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,.06);
            overflow: hidden;
            background: white;
            margin-bottom: 25px;
        }

        .dashboard-card .card-header {
            background: white;
            border-bottom: 1px solid #edf0f5;
            padding: 20px 25px;
            font-weight: 700;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0;
        }

        .admin-sidebar {
            min-height: 100vh;
            width: 280px;
            background: #f4f9fd; /* Light blue background */
            color: #1a2b4c;
            border-right: 1px solid #eaeaea;
        }
        
        .admin-sidebar .sidebar-menu {
            padding: 20px 15px;
            margin-top: 20px;
        }

        .sidebar-link {
            color: #1a2b4c;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 14px 15px;
            font-size: 15px;
            font-weight: 500;
            transition: 0.2s;
            border-radius: 8px;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
            margin-bottom: 5px;
        }
        
        .sidebar-link:hover, .sidebar-link.active {
            background-color: #c7e2fb !important;
            color: #000 !important;
            border-radius: 8px;
        }
        
        .sidebar-link .icon-left {
            width: 25px;
            text-align: center;
            margin-right: 15px;
            font-size: 18px;
            color: #3b4e68;
        }

        .sidebar-link.active .icon-left, .sidebar-link:hover .icon-left {
            color: #000 !important;
        }
    </style>
    <div class="container-fluid bg-white p-0" style="position: sticky; top: 0; z-index: 1020;">
        <?php $this->load->view('components/header', ['ListingPages'=>'yes']); ?>
    </div>

    <div class="d-flex">
        <!-- side menu bar starts -->
        <div class="admin-sidebar d-none d-lg-block">
            <div class="sidebar-menu">
                <?= $btnInformation.$btnPricing.$btnFeatures.$btnImages.$btnDocuments.$btnPreview; ?>
            </div>
        </div>
        <!-- side menu bar ends -->

        <!-- inner section starts -->
        <div style="width: 100%;">
          <div class="border-0 mx-1 px-2">

            <!-- mobile screen menu bar -->
            
            <div class="offcanvas offcanvas-top mt-5 bg-light h-50" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
              <div class="offcanvas-header mt-5">
                <h5 class="offcanvas-title text-dark" id="offcanvasTopLabel">Menu</h5>
                <button type="button" class="text-dark border-0 bg-light" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-xmark fs-3"></i></button>
              </div>
              <div class="offcanvas-body">
                <div class="sidebar-menu w-100 mx-auto" style="max-width: 400px;">
                    <?= $btnInformation.$btnPricing.$btnFeatures.$btnImages.$btnDocuments.$btnPreview; ?>
                </div>
              </div>
            </div>
            <!-- end -->
            
            <?php
            // Calculate completion states
            $statusInfo = 'empty';
            $statusPrice = 'empty';
            $statusFeatures = 'empty';
            $statusMedia = 'empty';
            $statusDocs = 'empty';

            if (isset($PropertyId) && $PropertyId > 0) {
                // 1. Basic Info
                $prop = $this->db->get_where('tbl_properties', ['PropertyId' => $PropertyId])->row();
                if ($prop) {
                    $statusInfo = 'completed';
                    
                    // 2. Pricing
                    if (!empty($prop->ListType)) {
                        $statusPrice = 'completed';
                    } else {
                        $statusPrice = 'skipped';
                    }

                    // 3. Features
                    $feat = $this->db->get_where('tbl_properties_features', ['PropertyId' => $PropertyId])->row();
                    if ($feat) {
                        $statusFeatures = 'completed';
                    } else {
                        $statusFeatures = 'skipped';
                    }

                    // 4. Media
                    $mediaCount = $this->db->get_where('tbl_documents', ['ReferenceId' => $PropertyId, 'Reference' => 'Properties'])->num_rows();
                    if ($mediaCount > 0) {
                        $statusMedia = 'completed';
                    } else {
                        $statusMedia = 'skipped';
                    }

                    // 5. Documents
                    $docCount = $this->db->get_where('tbl_property_documents', ['PropertyId' => $PropertyId])->num_rows();
                    if ($docCount > 0) {
                        $statusDocs = 'completed';
                    } else {
                        $statusDocs = 'skipped';
                    }
                }
            }

            $steps = [
                ['id' => 'information', 'label' => 'Basic Info', 'status' => $statusInfo, 'link' => $lnkInformation],
                ['id' => 'pricing', 'label' => 'Pricing', 'status' => $statusPrice, 'link' => $lnkPricing],
                ['id' => 'features', 'label' => 'Features', 'status' => $statusFeatures, 'link' => $lnkFeatures],
                ['id' => 'media', 'label' => 'Media', 'status' => $statusMedia, 'link' => $lnkImages]
            ];
            if ($DocTypesCount > 0) {
                $steps[] = ['id' => 'documents', 'label' => 'Documents', 'status' => $statusDocs, 'link' => $lnkDocuments];
            }
            $steps[] = ['id' => 'preview', 'label' => 'Preview', 'status' => 'empty', 'link' => $lnkPreview];
            
            $currentSubView = ($SubView == '') ? 'information' : $SubView;
            ?>

            <style>
                .progress-bar-container {
                    display: flex;
                    align-items: flex-start;
                    justify-content: space-between;
                    margin-bottom: 25px;
                    padding: 30px 20px 20px;
                    background: #fff;
                    border-radius: 20px;
                    box-shadow: 0 5px 20px rgba(0,0,0,.06);
                    position: relative;
                }

                .progress-line-bg {
                    position: absolute;
                    top: 49px;
                    left: 10%;
                    right: 10%;
                    height: 3px;
                    background-color: #808080;
                    z-index: 0;
                }

                .progress-step {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    position: relative;
                    z-index: 1;
                    flex: 1;
                    cursor: pointer;
                    text-decoration: none;
                }

                .step-circle {
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    background-color: #808080; /* empty */
                    color: white;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 16px;
                    margin-bottom: 10px;
                    transition: all 0.3s;
                }

                .step-circle.completed {
                    background-color: #28a745;
                }

                .step-circle.skipped {
                    background-color: #dc3545;
                }

                .step-circle.active-step {
                    box-shadow: 0 0 0 6px rgba(128, 128, 128, 0.2);
                }
                .step-circle.active-step.completed {
                    box-shadow: 0 0 0 6px rgba(40, 167, 69, 0.2);
                }
                .step-circle.active-step.skipped {
                    box-shadow: 0 0 0 6px rgba(220, 53, 69, 0.2);
                }

                .step-label {
                    font-size: 13px;
                    font-weight: 600;
                    color: #6c757d;
                    text-align: center;
                    max-width: 100px;
                    line-height: 1.2;
                }
            </style>

            <!-- <div class="progress-bar-container">
                <div class="progress-line-bg"></div>
                
                <?php foreach($steps as $index => $step): ?>
                    <?php 
                        $icon = '<i class="fa-solid fa-check"></i>';
                        if ($step['status'] == 'skipped') $icon = '<i class="fa-solid fa-xmark"></i>';
                        if ($step['status'] == 'empty') $icon = $index + 1;
                        
                        $isActive = ($step['id'] == $currentSubView) ? 'active-step' : '';
                    ?>
                    <div class="progress-step dashboard-nav-item actLoadLink" <?= $step['link'] ?>>
                        <div class="step-circle <?= $step['status'] ?> <?= $isActive ?>">
                            <?= $icon ?>
                        </div>
                        <div class="step-label">
                            <?= $step['label'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div> -->

            <div id="divContent" class="body">
                <div class="tab-content padding-0">
                    <div class="tab-pane active" id="divGeneralInformation">

                    </div>
                </div>
            </div>
            <div class="text-center d-none" id="loadSpin" style="padding: 25% 0 25% 0;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
          <?php $this->load->view('components/footer.php'); ?>
        </div>
        <!-- inner section ends -->

    </div>

    <?php
    
    $this->load->view('components/js_links.php');
    $this->load->view('Home/index_functions.php');
    
    ?>

<script type="text/javascript">

  $(document).ready(function(){

   var base_url = "<?= base_url();?>";
   var loadURL = "<?= $loadURL;?>";

   $("#divGeneralInformation").load(base_url+loadURL) ;


   $(document).off('click','.dashboard-nav-item');
   $(document).on('click', '.dashboard-nav-item', function(e){

      e.preventDefault();
      
      var loadlink = $(this).attr('loadlink');
      var parts = loadlink.split('/');
      var propertyId = parts[parts.length - 1];
      
      if ((propertyId == 0 || propertyId == '') && $(this).attr('id') != 'btnInformation') {
          var targetTab = $(this);
          Swal.fire({
              icon: 'warning',
              title: 'Hold On!',
              text: 'Please save the initial Property Information before proceeding to other tabs.',
              showCancelButton: true,
              confirmButtonText: 'Skip & Next',
              cancelButtonText: 'Stay Here'
          }).then((result) => {
              if (result.isConfirmed) {
                  $('.dashboard-nav-item').removeClass('active');
                  targetTab.addClass('active');
                  var nextLink = targetTab.attr('loadlink');
                  $("#divGeneralInformation").html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-3x text-primary"></i></div>');
                  $("#divGeneralInformation").load(base_url + nextLink);
              }
          });
          return;
      }

      $('.dashboard-nav-item').removeClass('active');
      $(this).addClass('active');

      $("#divGeneralInformation").html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-3x text-primary"></i></div>');
      $("#divGeneralInformation").load(base_url+loadlink) ;

   });
  });

</script>