<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Properties extends CI_Controller {

	
 function __construct()
 {
	parent::__construct();
    $this->load->model('home_model');
 }

 public function LoadAddress()
	{		
    	$callback     = $this->input->get('callback');
    	$Value        = $this->input->get('str');
		$details_url  = 'https://suggest.realestate.com.au/consumer-suggest/suggestions?max=7&type=address&src=homepage-web&query='.$Value;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $details_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = json_decode(curl_exec($ch), true);

		$dataArray = $response['_embedded']['suggestions'] ?? [];
        $DataListArray = [];
        
        if(!empty($dataArray))
        {
			foreach ($dataArray as $value) 
			{
				$label 				= $value['display']['text'] ?? '';
				$streetName 		= $value['source']['streetName'] ?? '';
				$suburb 			= $value['source']['suburb'] ?? '';
				$streetNumber 		= $value['source']['streetNumber'] ?? '';
				$lotNumber 			= $value['source']['lotNumber'] ?? '';
				$shortAddress 		= $value['source']['shortAddress'] ?? '';
				$state 				= $value['source']['state'] ?? '';
				$url 				= $value['source']['url'] ?? '';
				$postcode 			= $value['source']['postcode'] ?? '';
			
				if($label)
				{
					$DataListArray[]= [
		              "label"           	=> $label,
		              "streetName"    		=> $streetName,
		              "suburb"           	=> $suburb,
		              "streetNumber"        => $streetNumber,
		              "lotNumber"           => $lotNumber,
		              "shortAddress"        => $shortAddress,
		              "state"           	=> $state,
		              "url"           		=> $url,
		              "postcode"           	=> $postcode,
		            ]; 
				}
			}
			echo $callback.'('.json_encode($DataListArray).')';
        }
		else
		{
			$DataListArray[]='No Record Found'; 
			echo $callback.'('.json_encode($DataListArray).')';
		}
	}

	public function LoadFunctions()
	{		
	    $this->load->view('Home/index_functions');
	}

  public function smart_contract($Case = 'sale_contract')
  {
      require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

      $data = [
          'SellerName'       => $this->input->post('txtSellerName') ?? '--',
          'BuyerName'        => $this->input->post('txtBuyerName') ?? '--',
          'PropertyAddress'  => $this->input->post('txtPropertyAddress') ?? '--',
          'PurchasePrice'    => '$ ' . ($this->input->post('txtPurchasePrice') ?? '0'),
          'DepositAmount'    => '$ ' . ($this->input->post('txtDepositAmount') ?? '0'),
          'SettlementDate'   => $this->input->post('txtSettlementDate') ?? '--',
      ];

      switch ($Case) {
        case 'sale_contract':
          $html = $this->load->view('contract_templates/sale_contract', $data, true);
          $filename = 'FRE-SALE-CONTRACT.pdf';
          break;

        case 'deed_of_conveyance':
          $html = $this->load->view('contract_templates/deed_of_conveyance', $data, true);
          $filename = 'FRE-DEED-OF-CONVEYANCE.pdf';
          break;
          
        default:
          exit('Invalid contract type');
      }

      $options = new Options();
      $options->set('isRemoteEnabled', true);

      $dompdf = new Dompdf($options);
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();

      ob_end_clean(); 

      $dompdf->stream($filename, ["Attachment" => true]);
      exit;
  }

  public function launcher_page()
  {
    $this->load->view('launcher_page');
  }

  public function launcher_page2()
  {
    $this->load->view('launcher_page2');
  }

  public function view_user_docs()
  {
    $this->load->view('view_user_docs');
  }

  public function NearByPlaces()
  {
    $address = $this->input->post('txtInputAddress');
    // TODO: Move API Key to .env or configuration to avoid hardcoding!
    $apiKey = "AIzaSyCv1FrfWK8d_Z28pT_XtiZW02msCfrC2Rs";

    $geoUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $apiKey;
    $geoResponse = file_get_contents($geoUrl);
    $geoData = json_decode($geoResponse, true);

    if (empty($geoData['results'])) {
        die("No location found for: " . htmlspecialchars($address));
    }

    $lat = $geoData['results'][0]['geometry']['location']['lat'];
    $lng = $geoData['results'][0]['geometry']['location']['lng'];

    $nearbyUrl = "https://places.googleapis.com/v1/places:searchNearby";

    $postData = [
        "maxResultCount" => 10,
        "locationRestriction" => [
            "circle" => [
                "center" => [
                    "latitude" => $lat,
                    "longitude" => $lng
                ],
                "radius" => 5000.0 
            ]
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $nearbyUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "X-Goog-Api-Key: $apiKey",
        "X-Goog-FieldMask: places.displayName,places.formattedAddress,places.location"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (!empty($data['places'])) {
        echo "<h3>Nearby Places:</h3><ul>";
        foreach ($data['places'] as $place) {
            echo "<li><strong>" . $place['displayName']['text'] . "</strong><br>";
            echo $place['formattedAddress'] . "<br>";
            echo "Lat: " . $place['location']['latitude'] . ", Lng: " . $place['location']['longitude'];
            echo "</li><br>";
        }
        echo "</ul>";
    } else {
        echo "<pre>No places found. Debug:\n" . htmlspecialchars($response) . "</pre>";
    }
  }

  public function property_user_docs()
  {
    if (!$this->session->userdata('user_id')) {
        redirect('Properties/signin');
    }
    $UserId = $this->session->userdata('user_id');
    $this->load->model('Admin_User_Verifications_Model');
    $data['verification_rules'] = $this->Admin_User_Verifications_Model->get_rules();
    $data['uploaded_docs'] = $this->db->where('ReferenceId', $UserId)
                                      ->where('Reference', 'Client')
                                      ->get('tbl_documents')->result();
    $this->load->view('user_docs', $data);
  }

  public function submit_user_docs() {
    if (!$this->session->userdata('user_id')) {
        redirect('Properties/signin');
    }
    
    $UserId = $this->session->userdata('user_id');
    $this->load->model('Admin_User_Verifications_Model');
    $rules = $this->Admin_User_Verifications_Model->get_rules();

    $uploadPath = "uploads/Client/$UserId/images";
    if (!is_dir(FCPATH . $uploadPath)) {
        mkdir(FCPATH . $uploadPath, 0777, true);
    }

    // Process each rule dynamically
    foreach ($rules as $rule) {
        $inputName = "rule_" . $rule->RuleId;
        
        if ($rule->InputType == 'File') {
            if (isset($_FILES[$inputName]) && !empty($_FILES[$inputName]['name'])) {
                // If multiple
                if (is_array($_FILES[$inputName]['name'])) {
                    $fileCount = count($_FILES[$inputName]['name']);
                    for ($i = 0; $i < $fileCount; $i++) {
                        if (!empty($_FILES[$inputName]['name'][$i])) {
                            $_FILES['file']['name']     = $_FILES[$inputName]['name'][$i];
                            $_FILES['file']['type']     = $_FILES[$inputName]['type'][$i];
                            $_FILES['file']['tmp_name'] = $_FILES[$inputName]['tmp_name'][$i];
                            $_FILES['file']['error']    = $_FILES[$inputName]['error'][$i];
                            $_FILES['file']['size']     = $_FILES[$inputName]['size'][$i];
                            
                            $this->upload_single_doc($rule->DocumentTitle, $UserId, 'file');
                        }
                    }
                } else {
                    $this->upload_single_doc($rule->DocumentTitle, $UserId, $inputName);
                }
            }
        } else {
            // Text, Number, TextAndNumber, Date
            $val = $this->input->post($inputName);
            if (!empty($val)) {
                $data = [
                    'ReferenceId' => $UserId,
                    'Reference' => 'Client',
                    'Remarks' => $rule->DocumentTitle,
                    'FileName' => $val, // storing text data here
                    'UploadedBy' => $UserId,
                    'UploadTime' => date('Y-m-d H:i:s'),
                    'VerificationStatus' => 'Pending'
                ];
                
                // If it's a date, we can optionally store it in ExpiryDate as well
                if ($rule->InputType == 'Date') {
                    $data['ExpiryDate'] = $val;
                }
                
                $this->db->insert('tbl_documents', $data);
            }
        }
    }

    $this->session->set_flashdata('success', 'Documents submitted successfully.');
    redirect('Properties/user_dashboard');
  }

  private function upload_single_doc($docTitle, $UserId, $fieldName) {
      $uploadPath = "uploads/Client/$UserId/images/";
      
      $config['upload_path']   = FCPATH . $uploadPath;
      $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|ppt|pptx|xls|xlsx|rtf|webp|txt';
      $config['max_size']      = 20480; // 20MB
      $config['encrypt_name']  = TRUE;

      $this->load->library('upload');
      $this->upload->initialize($config);

      if ($this->upload->do_upload($fieldName)) {
          $uploadData = $this->upload->data();
          $data = [
              'ReferenceId' => $UserId,
              'Reference' => 'Client',
              'Remarks' => $docTitle,
              'FileName' => $uploadData['file_name'],
              'FileSize' => $uploadData['file_size'],
              'UploadedBy' => $UserId,
              'UploadTime' => date('Y-m-d H:i:s'),
              'VerificationStatus' => 'Pending'
          ];
          $this->db->insert('tbl_documents', $data);
      }
  }

  public function request_status_update($InspectionId='')
  {
    $this->db->where('InspectionId', (int)$InspectionId)->update('tbl_properties_inspection', ['InspectionStatus'=>'Accepted']);
    redirect('Properties/user_dashboard');
  }

  public function PropertyEnquiry()
  {
    $Response['Status']  = false;

    $RequestedOn = date('Y-m-d H:i:s');
    $RequestedBy = $this->input->post('RequestedBy');

    $data = [
        'PropertyId'  => $this->input->post('PropertyId'),
        'RequestedBy' => $RequestedBy,
        'RequestedOn' => $RequestedOn,
        'SellerId'    => $this->input->post('SellerId'),
        'Remarks'     => $this->input->post('txtRemarks'),
        'MeetDate'    => $this->input->post('txtMeetDate'),
        'MeetTime'    => $this->input->post('txtMeetTime'),
        'TourType'    => $this->input->post('chkTourType'),
        'UpdatedOn'   => $RequestedOn,
        'UpdatedBy'   => $RequestedBy,
    ];

    $this->db->insert('tbl_properties_inspection', $data);

    if($this->db->affected_rows() > 0)
    {
        $Response['Status']  = true;
        $Response['url']     = 'Properties/PropertyDetails/' . $data['PropertyId'];
        $Response['Message'] = 'Request Processed Successfully';
    }
    exit(json_encode($Response));
  }

  public function user_dashboard()
  {
    $this->load->view('user_dashboard');
  }

  public function contract()
  {
    $this->load->view('contract');
  }

  public function UpdateRequestStatus($InspectionId='')
  {
    $this->db->where('InspectionId', (int)$InspectionId)->update('tbl_properties_inspection', ['InspectionStatus' => 'Approved']);
    $this->load->view('user_dashboard');
  }

  public function AddToFavourites($PropertyId='', $BackPage='Properties')
  {
    $UserId = $this->session->userdata('user_id');
    
    $IsDuplicate = $this->db->get_where('tbl_properties_favourites', ['PropertyId' => $PropertyId, 'UserId' => $UserId])->row();

    if (!$IsDuplicate)
    {
      $data = [
          'PropertyId'  => $PropertyId,
          'UserId'      => $UserId,
          'AddedOn'     => date('Y-m-d H:i:s'),
          'AddedBy'     => $UserId,
          'UpdatedOn'   => date('Y-m-d H:i:s'),
          'UpdatedBy'   => $UserId,
      ];
      $this->db->insert('tbl_properties_favourites', $data);
    }

    if ($BackPage !== 'Properties') {
        redirect($BackPage);
    } else if (!empty($_SERVER['HTTP_REFERER'])) {
        redirect($_SERVER['HTTP_REFERER']);
    } else {
        redirect('Properties');
    }
  }

  public function RemoveFromFavourites($PropertyId='', $BackPage='Properties')
  {
    $UserId = $this->session->userdata('user_id');

    $this->db->where(['PropertyId' => $PropertyId, 'UserId' => $UserId])
             ->delete('tbl_properties_favourites');

    if ($BackPage !== 'Properties') {
        redirect($BackPage);
    } else if (!empty($_SERVER['HTTP_REFERER'])) {
        redirect($_SERVER['HTTP_REFERER']);
    } else {
        redirect('Properties');
    }
  }

  public function chatting($InspectionId='', $PropertyId='', $SellerId='', $BuyerId='')
  {
    $data = [
        'InspectionId' => $InspectionId,
        'PropertyId'   => $PropertyId,
        'SellerId'     => $SellerId,
        'BuyerId'      => $BuyerId
    ];
    $this->load->view('chatting', $data);
  }

  public function fetch_messages($InspectionId = '')
  {
    $messages = $this->db->where('InspectionId', (int)$InspectionId)->order_by('AddedOn', 'ASC')->get('tbl_properties_messages')->result();
    $UserId = $this->session->userdata('user_id');

    foreach ($messages as $msg):
      $align = ($msg->SenderId == $UserId) ? 'end' : 'start'; ?>
      <div class="d-flex justify-content-<?= $align ?> mb-2">
        <div class="p-2 fw-bold fs-6 bg-light text-dark rounded">
          <div><?= nl2br(htmlspecialchars($msg->Message)) ?></div>
          <small class="fs-6 fw-normal text-muted"><?= date('d M, h:i A', strtotime($msg->AddedOn)) ?></small>
        </div>
      </div>
    <?php endforeach;
  }

  public function send_message()
  {
    $Response['Status'] = false;

    $InspectionId = $this->input->post('InspectionId');
    $SellerId = $this->input->post('SellerId');
    $BuyerId = $this->input->post('BuyerId');
    $UserId = $this->session->userdata('user_id');

    $SenderId = $UserId;
    $ReceiverId = ($SellerId == $UserId) ? $BuyerId : (($BuyerId == $UserId) ? $SellerId : 0);

    $data = [
        'ReceiverId'    => $ReceiverId,
        'SenderId'      => $SenderId,
        'InspectionId'  => $InspectionId,
        'Message'       => $this->input->post('message'),
        'AddedOn'       => date('Y-m-d H:i:s'),
        'AddedBy'       => $UserId,
        'UpdatedOn'     => date('Y-m-d H:i:s'),
        'UpdatedBy'     => $UserId
    ];

    $this->db->insert('tbl_properties_messages', $data);

    if($this->db->affected_rows() > 0)
    {
      $Response['Status']  = true;
      $Response['Message'] = 'Request Processed Successfully';
    }
    exit(json_encode($Response));
  }

  public function user_account()
  {
    $this->load->view('user_account');
  }

  public function news()
  {
    $this->load->view('news');
  }

  public function news_details()
  {
    $this->load->view('news_details');
  }

  public function contact()
  {
    $this->load->view('contact_page');
  }

  public function map()
  {
    $this->load->view('map');
  }

  public function ImageUpload($Case='Identity', $Reference = 'Client', $ReferenceId = 0)
  {   
      $Response['Status'] = false;
      $varNow         = date('Y-m-d H:i:s');
      $AdminId        = $this->session->userdata('user_id');
      $AdminName      = $this->session->userdata('user_name');
      $StationId      = $this->session->userdata('active_station') ?? '9';
      $ReferenceId    = $AdminId;
      $ImagePath      = "uploads/$Reference/$ReferenceId/images";
      $uploadDir      = FCPATH . $ImagePath;

      if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0777, true);
      }

      $images_count = count($_FILES['images']['name'] ?? []);

      for ($i = 0; $i < $images_count; $i++) {
          $_FILES['file']['name']     = $_FILES['images']['name'][$i];
          $_FILES['file']['type']     = $_FILES['images']['type'][$i];
          $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
          $_FILES['file']['error']    = $_FILES['images']['error'][$i];
          $_FILES['file']['size']     = $_FILES['images']['size'][$i];

          $config = [
              'upload_path'   => $uploadDir,
              'allowed_types' => 'jpg|jpeg|png|gif',
              'max_size'      => 30000,
              'encrypt_name'  => true,
          ];

          $this->upload->initialize($config);

          if ($this->upload->do_upload('file')) 
          {
            $Response['Status'] = true;
            $fileData = $this->upload->data();
            
            $ModelData = [
                'FileName'      => $fileData['file_name'],
                'FileSize'      => $fileData['file_size'],
                'ReferenceId'   => $ReferenceId,
                'Reference'     => ucwords(str_replace("_", " ", $Reference)),
                'ReferenceName' => $AdminName,
                'StationId'     => $StationId,
                'UploadedBy'    => $AdminId,
                'UploadTime'    => $varNow
            ];

            switch ($Case) 
            {
              case 'Identity':
                $ModelData['Remarks']         = ($i == 0) ? "License Front" : "License Back";
                $ModelData['ReferenceNumber'] = $this->input->post('txtLicenseNumber');
                $ModelData['ExpiryDate']      = $this->input->post('txtLicenseExpiryDate');
                $ModelData['DocumentTypeId']  = '11';
                $ModelData['DocumentTitle']   = 'Driving License';
                break;

              case 'Passport':
                $ModelData['Remarks']         = "Passport";
                $ModelData['ReferenceNumber'] = $this->input->post('txtPassportNumber');
                $ModelData['DocumentTypeId']  = '11';
                $ModelData['DocumentTitle']   = 'Passport';
                break;

              case 'Address':
                $ModelData['Remarks']         = "Address Details";
                $ModelData['ReferenceNumber'] = $this->input->post('txtLicenseNumber');
                $ModelData['ExpiryDate']      = $this->input->post('txtLicenseExpiryDate');
                $ModelData['DocumentTypeId']  = '11';
                $ModelData['DocumentTitle']   = 'Address Details';
                break;
            }

            $this->db->insert('tbl_documents', $ModelData);

            $DOB            = $this->input->post('txtDOB');
            $CardNumber     = $this->input->post('txtCardNumber');
            $CardIssueDate  = $this->input->post('txtCardIssueDate');
            $CardExpiryDate = $this->input->post('txtCardExpiryDate');
          }

          if($Response['Status'] == true)
          {
            $ModelDataClient = [
                'DOB'            => $DOB ?? null,
                'CardNumber'     => $CardNumber ?? null,
                'CardIssueDate'  => $CardIssueDate ?? null,
                'CardExpiryDate' => $CardExpiryDate ?? null
            ];

            $this->db->where('ClientId', $AdminId);
            $this->db->update('tbl_clients', $ModelDataClient);
          }
      }

      exit(json_encode($Response));
  }

  public function filter_search()
  {
      $this->db->select('*');
      $this->db->from('tbl_properties');
      $this->db->join('tbl_properties_features', 'tbl_properties.PropertyId = tbl_properties_features.PropertyId', 'left');
      $this->db->where('tbl_properties.Status', 'Published');
      $this->db->where('tbl_properties.IsDeleted', 0);

      $likeFields = [
          'tbl_properties.PropertyTitle'  => $this->input->post('txtPropertyTitle'),
          'tbl_properties.MailingAddress' => $this->input->post('txtMailingAddress'),
          'tbl_properties.State'          => $this->input->post('txtState'),
          'tbl_properties.Suburb'         => $this->input->post('txtSuburb')
      ];

      foreach($likeFields as $field => $val) {
          if (!empty($val)) $this->db->like($field, $val);
      }

      $whereFields = [
          'tbl_properties.PropertyTypeId'     => $this->input->post('ddPropertyType'),
          'tbl_properties.ListType'           => $this->input->post('ddListType'),
          'tbl_properties_features.Bedrooms'  => $this->input->post('ddBedrooms'),
          'tbl_properties_features.Bathrooms' => $this->input->post('ddBathrooms')
      ];

      foreach($whereFields as $field => $val) {
          if (!empty($val)) $this->db->where($field, $val);
      }

      if ($MinPrice = $this->input->post('txtMinPrice')) $this->db->where('tbl_properties.TotalPrice >=', $MinPrice);
      if ($MaxPrice = $this->input->post('txtMaxPrice')) $this->db->where('tbl_properties.TotalPrice <=', $MaxPrice);
      if ($MinArea  = $this->input->post('txtMinArea'))  $this->db->where('tbl_properties.CoveredArea >=', $MinArea);
      if ($MaxArea  = $this->input->post('txtMaxArea'))  $this->db->where('tbl_properties.CoveredArea <=', $MaxArea);
      
      if ($BuiltInYear = $this->input->post('txtBuiltInYear')) {
          $this->db->where('YEAR(tbl_properties_features.BuiltInYear)', date('Y', strtotime($BuiltInYear)));
      }

      $checkboxes = [
          'CentralAirConditioning' => 'chkIsCentralAirConditioning',
          'CentralHeating'         => 'chkIsCentralHeating',
          'LaundryRoom'            => 'chkIsLaundryRoom',
          'Gym'                    => 'chkIsGym',
          'Alarm'                  => 'chkIsAlarm',
          'Balcony'                => 'chkIsBalcony',
          'Internet'               => 'chkIsInternet',
          'DrawingRoom'            => 'chkIsDrawingRoom',
          'DiningRoom'             => 'chkIsDiningRoom',
          'Kitchen'                => 'chkIsKitchen',
          'StudyRoom'              => 'chkIsStudyRoom',
          'PrayerRoom'             => 'chkIsPrayerRoom',
          'PowderRoom'             => 'chkIsPowderRoom',
          'StoreRoom'              => 'chkIsStoreRoom',
          'Lounge'                 => 'chkIsLounge',
          'SatelliteOrCable'       => 'chkIsSatelliteOrCable',
          'Intercom'               => 'chkIsIntercom',
          'CommunityGym'           => 'chkIsCommunityGym',
          'CommunityLawnOrGarden'  => 'chkIsCommunityLawnOrGarden',
          'SwimmingPool'           => 'chkIsSwimmingPool'
      ];

      foreach($checkboxes as $dbField => $postField) {
          if ($this->input->post($postField)) {
              $this->db->where("tbl_properties_features.{$dbField}", 1);
          }
      }

      $data['properties'] = $this->db->get()->result();
      
      $this->db->where('Status', 'Published');
      $this->db->order_by('CreatedAt', 'DESC');
      $data['Blogs'] = $this->db->get('tbl_blogs')->result();

      $this->load->view('home', $data);
  }

  public function luxury_house()
  {
      $this->load->view('property_details_static');
  }

  public function index()
  {
      $data['Properties'] = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', '*', "WHERE PropertyTypeId > 0 AND IsDeleted = 0 AND Status = 'Published' ORDER BY PropertyId DESC LIMIT 0,12");
      
      $this->db->where('Status', 'Published');
      $this->db->order_by('CreatedAt', 'DESC');
      $data['Blogs'] = $this->db->get('tbl_blogs')->result();
      
      $this->load->view('home', $data);
  }

  public function all_properties()
  {
      $data['Properties'] = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', '*', "WHERE PropertyTypeId > 0 AND IsDeleted = 0 AND Status = 'Published' ORDER BY PropertyId DESC");
      $this->load->view('all_properties', $data);
  }

  public function PrivacyPolicy()
  {
    $this->load->view('privacypolicy_page');
  }

  public function signin()
  {
    $this->load->view('login_form');
  }

  public function login()
  {
    $this->load->view('login_form');
  }

  public function join($PropertyId = 0)
  {
    $data['PropertyId'] = $PropertyId;
    $this->load->view('join', $data);
  }

  public function dashboard()
  {
    $this->user_dashboard();
  }

  public function Home()
  {
    $this->index();
  }

  public function AllListings()
  {
    $this->load->view('all_listings');
  }

  public function ListProperty($Case='Add', $encData='Jaunt', $PropertyId=0, $SubView='information')
  {
    $data = [
        'PageReference' => "Properties/AddListing/$encData/$PropertyId/$SubView",
        'PageTitle'     => 'List Property',
        'StationId'     => '9',
        'CountryId'     => '6',
        'RegionId'      => '6',
        'Case'          => $Case
    ];
    $this->load->view('index_external', $data);
  } 

  public function AddListing($PropertyId=0, $Case = 'Add', $SubView='information' )
  {
    $data = [
        'StationId'  => '9',
        'PropertyId' => $PropertyId,
        'Case'       => $Case,
        'SubView'    => $SubView
    ];
    $this->load->view('list_property_form', $data);
  }

  public function AddProperty($Case='Add', $PropertyId=0) 
  {
    $data = ['Case' => $Case, 'PropertyId' => $PropertyId];
    $this->load->view('property_add', $data);
  }

  public function SavePropertyInformation($Case='Add', $PropertyId=0)
  {
    $Response['Status'] = false;
    
    $UserId      = $this->session->userdata('user_id');
    $varNow      = $this->input->post('txtAddedOn');

    $ModelDataProperty = [
        'PropertyTitle'       => $this->input->post('txtPropertyTitle'),
        'PropertyTypeId'      => $this->input->post('chkPropertyType'),
        'OwnershipId'         => $UserId,
        'CoveredArea'         => $this->input->post('txtCoveredArea'),
        'PropertyStatus'      => $this->input->post('selPropertyStatus'),
        'PropertyDescription' => $this->input->post('txtPropertyDescription'),
        'MailingAddress'      => $this->input->post('txtPropertyAddress'),
        'Country'             => $this->input->post('selCountry'),
        'ZipCode'             => $this->input->post('numZipCode'),
        'Suburb'              => $this->input->post('suburb'),
        'State'               => $this->input->post('state'),
        'UnitNumber'          => $this->input->post('txtUnitNumber'),
        'BuildingNumber'      => $this->input->post('txtBuildingNumber'),
        'StreetNumber'        => $this->input->post('txtStreetNumber'),
        'StreetName'          => $this->input->post('txtStreetName'),
        'Longitude'           => $this->input->post('txtLongitude') !== '' ? $this->input->post('txtLongitude') : null,
        'Latitude'            => $this->input->post('txtLatitude') !== '' ? $this->input->post('txtLatitude') : null,
        'ClientId'            => $UserId,
        'OwnerEmail'          => $this->session->userdata('user_email'),
        'UpdatedBy'           => $UserId,
        'UpdatedOn'           => $varNow,
        'PostingDate'         => $varNow
    ];
  
    $this->session->set_userdata('property_sess_data', $ModelDataProperty);

    if ($Case == 'Add') {
        $ModelDataProperty['AddedBy']   = $UserId;
        $ModelDataProperty['AddedOn']   = $varNow;
        $ModelDataProperty['CompanyId'] = $this->session->userdata('user_company');
        $ModelDataProperty['StationId'] = $this->session->userdata('user_station');

        $this->db->insert('tbl_properties', $ModelDataProperty);
        if($this->db->affected_rows() > 0) {
            $PropertyId = $this->db->insert_id();
            $Response['Status']  = true;
            $Response['Message'] = 'Request Processed Successfully';
        }
    } else if ($Case == 'Edit') {
        $this->db->where('PropertyId', $PropertyId);
        $this->db->update('tbl_properties', $ModelDataProperty);
        $Response['Status'] = true;
    }

    $Response['url']        = 'Properties/AddListing/'.$PropertyId.'/'.$Case.'/pricing';
    $Response['PropertyId'] = $PropertyId;
    $Response['NextTab']    = 'btnPricing';
   
    exit(json_encode($Response));
  }

  public function AddPrice($Case='Add', $PropertyId=0, $StationId=0)
  {
    $data = ['Case' => $Case, 'PropertyId' => $PropertyId, 'StationId' => $StationId];
    $this->load->view('price', $data);
  }

  public function SavePropertyPrice($Case='Edit', $PropertyId=0)
  {
    $Response['Status'] = false;
    
    $UserId      = $this->session->userdata('user_id');
    $varNow      = date('Y-m-d H:i:s');

    $ModelDataProperty = [
        'ListType'            => $this->input->post('selListType'),
        'TotalPrice'          => (strtolower($this->input->post('selListType')) === 'sale') ? $this->input->post('numTotalPriceSale') : $this->input->post('numTotalPriceRent'),
        'SecurityBond'        => (strtolower($this->input->post('selListType')) === 'sale') ? null : ($this->input->post('numSecurityBond') !== '' ? $this->input->post('numSecurityBond') : null),
        'Installments'        => $this->input->post('numInstallments') !== '' ? $this->input->post('numInstallments') : null,
        'InstallmentAmount'   => $this->input->post('numInstallmentAmount') !== '' ? $this->input->post('numInstallmentAmount') : null,
        'PossessionDate'      => $this->input->post('dateAvailableFrom') !== '' ? $this->input->post('dateAvailableFrom') : null,
        'UpdatedBy'           => $UserId,
        'UpdatedOn'           => $varNow
    ];
  
    $this->db->where('PropertyId', $PropertyId);
    $this->db->update('tbl_properties', $ModelDataProperty);
    
    $Response['Status'] = true;
    $Response['Message'] = 'Pricing saved successfully.';

    $Response['url']        = 'Properties/AddListing/'.$PropertyId.'/'.$Case.'/features';
    $Response['PropertyId'] = $PropertyId;
    $Response['NextTab']    = 'btnFeatures';
    
    exit(json_encode($Response));
  }

  public function AddFeatures($Case='Add', $PropertyId=0, $StationId=0)
  {
    $PropertyData = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'PropertyTypeId', "WHERE PropertyId = '".(int)$PropertyId."'", 2);
    $PropertyTypeId = $PropertyData->PropertyTypeId ?? 0;

    // Fetch dynamic features for this property type AND system features (PropertyTypeId = 0)
    $DynamicFeatures = $this->db->where('PropertyTypeId', $PropertyTypeId)
                                        ->or_where('PropertyTypeId', 0)
                                        ->get('tbl_properties_features_lists')->result();
    
    // Get mapped values
    $MappedValues = [];
    if ($PropertyId > 0) {
        $mappings = $this->db->where('PropertyId', $PropertyId)->get('tbl_property_feature_mapping')->result();
        foreach($mappings as $m) {
            $MappedValues[$m->FeatureId] = $m->FeatureValue;
        }
    }

    $data = [
        'Case' => $Case, 
        'PropertyId' => $PropertyId, 
        'StationId' => $StationId,
        'PropertyTypeId' => $PropertyTypeId,
        'DynamicFeatures' => $DynamicFeatures,
        'MappedValues' => $MappedValues
    ];
    $this->load->view('features', $data);
  }

  public function SaveFeatures($Case='Add', $PropertyId = 0)
  {
    $Response['Status'] = false;
    $UserId             = $this->session->userdata('user_id');

    // Fetch dynamic features submitted in the form
    // The form will submit fields like name="feature_12" where 12 is FeatureId
    
    // Clear old mappings
    $this->db->where('PropertyId', $PropertyId)->delete('tbl_property_feature_mapping');

    // Fetch all features to identify structural ones
    $featuresList = $this->db->get('tbl_properties_features_lists')->result();
    $featureTitles = [];
    foreach ($featuresList as $fl) {
        $featureTitles[$fl->FeatureId] = strtolower(trim($fl->Title));
    }

    $structMap = [
        'BuiltInYear' => ['built in year', 'year built'],
        'Bedrooms' => ['bedrooms'],
        'Bathrooms' => ['bathrooms'],
        'ParkingSpaces' => ['parking spaces'],
        'Floors' => ['floors'],
        'Kitchens' => ['kitchens'],
        'StoreRooms' => ['store rooms'],
        'ServantQuarters' => ['servant quarters']
    ];

    $structuralData = [];

    $postData = $this->input->post();
    foreach ($postData as $key => $value) {
        if (strpos($key, 'feature_') === 0 && $value !== '') {
            $FeatureId = str_replace('feature_', '', $key);
            $mappingData = [
                'PropertyId' => $PropertyId,
                'FeatureId' => $FeatureId,
                'FeatureValue' => $value
            ];
            $this->db->insert('tbl_property_feature_mapping', $mappingData);

            $title = $featureTitles[$FeatureId] ?? '';
            if ($title) {
                foreach ($structMap as $structCol => $aliases) {
                    if (in_array($title, $aliases)) {
                        $structuralData[$structCol] = $value;
                        break;
                    }
                }
            }
        }
    }

    if (!empty($structuralData)) {
        $exists = $this->db->where('PropertyId', $PropertyId)->get('tbl_properties_features')->row();
        if ($exists) {
            $this->db->where('PropertyId', $PropertyId)->update('tbl_properties_features', $structuralData);
        } else {
            $structuralData['PropertyId'] = $PropertyId;
            $this->db->insert('tbl_properties_features', $structuralData);
        }
    }

    $Response['Status']  = true;
    $Response['Message'] = 'Request Processed Successfully';

    $Response['url']        = 'Properties/AddListing/'.$PropertyId.'/'.$Case.'/images';
    $Response['PropertyId'] = $PropertyId;
    $Response['NextTab']    = 'btnImages';
   
    exit(json_encode($Response));
  }

  public function AddMedia($Case='Add', $PropertyId=0, $StationId=0)
  {
    $data = ['Case' => $Case, 'PropertyId' => $PropertyId, 'StationId' => $StationId];
    $this->load->view('images', $data);
  }

  public function AddDocuments($Case='Add', $PropertyId=0, $StationId=0)
  {
    $ListType = '';
    if ($PropertyId > 0) {
        $prop = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'ListType', "WHERE PropertyId='$PropertyId'", 2);
        if ($prop) $ListType = $prop->ListType;
    }
    
    // Fetch all document types that match this ListType or Both
    $DocTypes = $this->getlist_model->getFieldsMultipleConditions('tbl_property_document_types', '*', "WHERE PropertyType='Both' OR PropertyType='$ListType' OR PropertyType='' OR PropertyType IS NULL", 0);
    if(!is_array($DocTypes) && !is_object($DocTypes)) $DocTypes = [];

    // Fetch already uploaded documents for this property
    $UploadedDocs = $this->getlist_model->getFieldsMultipleConditions('tbl_property_documents', '*', "WHERE PropertyId='$PropertyId'", 0);
    if(!is_array($UploadedDocs) && !is_object($UploadedDocs)) $UploadedDocs = [];

    $data = [
        'Case' => $Case, 
        'PropertyId' => $PropertyId, 
        'StationId' => $StationId,
        'DocTypes' => $DocTypes,
        'UploadedDocs' => $UploadedDocs
    ];
    $this->load->view('documents', $data);
  }

  public function SavePropertyDocuments($PropertyId=0)
  {
      $Response['Status'] = false;
      $UserId = $this->session->userdata('user_id');
      
      $uploadDir = "uploads/PropertyDocs/$PropertyId";
      if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0777, true);
      }
      
      if (!empty($_FILES)) {
          foreach ($_FILES as $key => $file) {
              if (strpos($key, 'doc_') === 0 && $file['error'] == UPLOAD_ERR_OK) {
                  $DocTypeId = str_replace('doc_', '', $key);
                  $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '', $file['name']);
                  $target = "$uploadDir/$filename";
                  
                  if (move_uploaded_file($file['tmp_name'], $target)) {
                      $data = [
                          'DocTypeId' => $DocTypeId,
                          'PropertyId' => $PropertyId,
                          'SellerId' => $UserId,
                          'FilePath' => $filename,
                          'VerificationStatus' => 'Pending',
                          'UploadedDate' => date('Y-m-d H:i:s')
                      ];
                      
                      $exists = $this->getlist_model->getFieldsMultipleConditions('tbl_property_documents', 'DocumentId', "WHERE PropertyId='$PropertyId' AND DocTypeId='$DocTypeId'", 2);
                      if ($exists && isset($exists[0])) {
                          $this->db->where('DocumentId', $exists[0]->DocumentId)->update('tbl_property_documents', $data);
                      } else if ($exists && isset($exists->DocumentId)) {
                          $this->db->where('DocumentId', $exists->DocumentId)->update('tbl_property_documents', $data);
                      } else {
                          $this->db->insert('tbl_property_documents', $data);
                      }
                  }
              }
          }
      }
      
      $Response['Status'] = true;
      $Response['Message'] = 'Documents saved successfully.';
      
      if ($Response['Status']) {
          $Response['NextTab'] = 'btnPreview';
      }
      
      echo json_encode($Response);
  }

  public function DeletePropertyDocument($DocumentId = 0)
  {
      $Response['Status'] = false;
      if ($DocumentId > 0) {
          $doc = $this->db->get_where('tbl_property_documents', ['DocumentId' => $DocumentId])->row();
          if ($doc) {
              $filePath = FCPATH . 'uploads/PropertyDocs/' . $doc->PropertyId . '/' . $doc->FilePath;
              if (file_exists($filePath)) {
                  @unlink($filePath);
              }
              $this->db->where('DocumentId', $DocumentId)->delete('tbl_property_documents');
              $Response['Status'] = true;
          }
      }
      exit(json_encode($Response));
  }

  public function PropertyActions($Case = 'Details', $PropertyId = '')
  {
    $Response['Status'] = false;
    
    switch ($Case)
    {
      case 'Details':
        $Response['url']    = 'Properties/PropertyDetails/'.$PropertyId;
        $Response['Status'] = true;
        break;

      case 'Edit':
        redirect('Properties/AddListing/'.$PropertyId.'/Edit/information');
        break;

      case 'Delete':
        $IsDeleted = $this->input->post('IsDeleted') == 1 ? 0 : 1;

        $this->db->set('IsDeleted', $IsDeleted)
                 ->where('PropertyId', $PropertyId)
                 ->update('tbl_properties');

        if($this->db->affected_rows() > 0) {
          $Response['url']     = 'Properties/property_user_dashboard';
          $Response['Message'] = 'Request Processed Successfully';
          $Response['Status']  = true;
        } else {
          $Response['url']     = 'Properties/property_user_dashboard';
          $Response['Message'] = 'Some error occured. Please Try again.';
        }
        break;
    }

    exit(json_encode($Response));
  }

  public function PropertyDetails($PropertyId = 0)
  {
    $PropertyDetails = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', '*', "WHERE PropertyId = '" . (int)$PropertyId . "'", 2);

    $Longitude = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'Longitude', "WHERE PropertyId = '" . (int)$PropertyId . "'", 1);
    $Latitude  = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'Latitude', "WHERE PropertyId = '" . (int)$PropertyId . "'", 1);
        
    if ($PropertyDetails)
    {
      $data = [
          'PropertyId'      => $PropertyId,
          'Longitude'       => $Longitude ?? '',
          'Latitude'        => $Latitude ?? '',
          'PropertyDetails' => $PropertyDetails,
          'IsPreview'       => false
      ];
      $this->load->view('property_details', $data);
    }
    else
    {
        echo "No Features were added for this property, add some features to see details!!";
    }
  }

  public function PreviewProperty($Case='Add', $PropertyId = 0)
  {
    $PropertyDetails = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', '*', "WHERE PropertyId = '" . (int)$PropertyId . "'", 2);

    $Longitude = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'Longitude', "WHERE PropertyId = '" . (int)$PropertyId . "'", 1);
    $Latitude  = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'Latitude', "WHERE PropertyId = '" . (int)$PropertyId . "'", 1);
        
    if ($PropertyDetails)
    {
      $data = [
          'Case'            => $Case,
          'PropertyId'      => $PropertyId,
          'Longitude'       => $Longitude ?? '',
          'Latitude'        => $Latitude ?? '',
          'PropertyDetails' => $PropertyDetails,
          'IsPreview'       => true
      ];
      $this->load->view('property_details', $data);
    }
    else
    {
        echo "<div class='alert alert-warning text-center mt-5'>No details found for this property. Please fill out the basic information first.</div>";
    }
  }
  public function PublishProperty($PropertyId = 0)
  {
    $Response = ['Status' => false, 'Message' => ''];
    $PropertyId = (int)$PropertyId;
    
    $prop = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', '*', "WHERE PropertyId='$PropertyId'", 2);
    if (!$prop) {
        $Response['Message'] = 'Property not found.';
        exit(json_encode($Response));
    }

    $missing = [];

    // 1. General Info Validation
    $missingGeneral = [];
    if (empty(trim($prop->PropertyTitle ?? ''))) $missingGeneral[] = "Property Title";
    if (empty(trim($prop->CoveredArea ?? ''))) $missingGeneral[] = "Covered Area";
    if (empty(trim($prop->PropertyStatus ?? ''))) $missingGeneral[] = "Property Status";
    if (empty(trim($prop->PropertyDescription ?? ''))) $missingGeneral[] = "Description";
    if (empty(trim($prop->MailingAddress ?? ''))) $missingGeneral[] = "Mailing Address";
    
    if (count($missingGeneral) > 0) {
        $missing[] = "Basic Info Tab: <strong>" . implode(', ', $missingGeneral) . "</strong>";
    }

    // 2. Pricing Validation
    if (empty(trim($prop->TotalPrice ?? ''))) {
        $missing[] = "Pricing Tab: <strong>Total Price</strong>";
    }

    // 3. Features Validation
    $reqFeatures = $this->db->where('IsRequired', 1)
                            ->group_start()
                            ->where('PropertyTypeId', $prop->PropertyTypeId)
                            ->or_where('PropertyTypeId', 0)
                            ->group_end()
                            ->get('tbl_properties_features_lists')->result();
                            
    $mapped = $this->db->where('PropertyId', $PropertyId)->get('tbl_property_feature_mapping')->result();
    $mappedIds = [];
    foreach($mapped as $m) $mappedIds[] = $m->FeatureId;

    $missingFeat = [];
    foreach($reqFeatures as $rf) {
        if (!in_array($rf->FeatureId, $mappedIds)) {
            $missingFeat[] = $rf->Title;
        }
    }

    if (count($missingFeat) > 0) {
        $missing[] = "Features Tab: <strong>" . implode(', ', $missingFeat) . "</strong>";
    }

    // 4. Media Validation
    $images = $this->getlist_model->getFieldsMultipleConditions('tbl_documents', 'COUNT(*) as imgCount', "WHERE Reference='Properties' AND ReferenceId='$PropertyId'", 2);
    if (!$images || $images->imgCount == 0) {
        $missing[] = "Media Tab: <strong>At least one property image</strong>";
    }

    // 5. Documents Validation
    $ListType = $prop->ListType;
    $DocTypes = $this->getlist_model->getFieldsMultipleConditions('tbl_property_document_types', '*', "WHERE PropertyType='Both' OR PropertyType='$ListType' OR PropertyType='' OR PropertyType IS NULL", 0);
    if (!is_array($DocTypes)) $DocTypes = [];

    $UploadedDocs = $this->getlist_model->getFieldsMultipleConditions('tbl_property_documents', '*', "WHERE PropertyId='$PropertyId'", 0);
    if (!is_array($UploadedDocs)) $UploadedDocs = [];

    $missingDocs = [];
    foreach ($DocTypes as $type) {
        if ($type->IsMandatory == 1) {
            $found = false;
            foreach ($UploadedDocs as $doc) {
                if ($doc->DocTypeId == $type->DocTypeId) {
                    $found = true; break;
                }
            }
            if (!$found) $missingDocs[] = $type->DocumentTitle;
        }
    }
    
    if (count($missingDocs) > 0) {
        $missing[] = "Documents Tab: <strong>" . implode(', ', $missingDocs) . "</strong>";
    }

    if (count($missing) > 0) {
        $Response['Message'] = "Cannot publish! Please complete the following required fields across the tabs:<br><br><ul class='text-start mb-0'><li>" . implode("</li><li>", $missing) . "</li></ul>";
        exit(json_encode($Response));
    }

    // All good, publish it
    $this->db->where('PropertyId', $PropertyId)->update('tbl_properties', ['Status' => 'Published']);
    
    $Response['Status'] = true;
    $Response['Message'] = 'Your property has been successfully published and is now live!';
    exit(json_encode($Response));
  }

}
