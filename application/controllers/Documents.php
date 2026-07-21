<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documents extends CI_Controller {

  
  function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }



  public function ViewDocument($Reference='Properties', $ReferenceId=0, $FileName='')
  {
    if($Reference=='no-image.jpg' || ($Reference!='' && $ReferenceId > '0' && $FileName!=''))
    {
      if(strtolower($Reference) == 'candidate' || strtolower($Reference) == 'suppliers')
      {
        $file_url = "E:/uploads/".strtolower($Reference)."/".$ReferenceId."/".$FileName;
      }
      else
      {
          if($Reference == 'tickets')
          {
              $AdminId = $this->session->userdata('user_id');
              $TicketData=$this->getlist_model->getFieldsMultipleConditions('tickets_view','ManagerId, CCEmployeeIds, AssignedEmployeeIds, CategoryId, Title'," WHERE IsDeleted = '0' AND TicketId = '$ReferenceId' ",'2');

              $TicketCategory = $TicketData->CategoryId;
              $AssignedEmployeeIds = $TicketData->AssignedEmployeeIds;
              $TicketTitle = $TicketData->Title;
              $CCEmployeeIds = $TicketData->CCEmployeeIds;
              $expCCEmployee = explode(',', $CCEmployeeIds);
              $ManagerId = $TicketData->ManagerId;
              $RequestedById = '';
              foreach ($expCCEmployee as $key => $value) 
              {
                $RequestedById = ($AdminId == $value)?$value:$RequestedById;
              }
              if($TicketCategory == '17' && strpos($TicketTitle,'Performance Review') !== FALSE  )
              {
                $EmployeeId = $this->getlist_model->getFieldsMultipleConditions('tbl_tickets_item','EmployeeId',"WHERE TicketId = '$ReferenceId'",1);

                if($AdminId != $EmployeeId && $AdminId != $ManagerId && $AdminId != $AssignedEmployeeIds)
                {
                  exit();
                }
              }

            $file_url = "E:/uploads/".strtolower($Reference)."/".$ReferenceId."/".$FileName;
          }
          else
          {
            $file_url = "E:/uploads/".strtolower($Reference)."/".$ReferenceId."/".$FileName;
          }
      }
      $file_url = ($Reference=='no-image.jpg')?base_url("uploads/no-image.jpg"):$file_url;

      $ContentType=mime_content_type($file_url);
      header('Content-Type: '.$ContentType);
      header("Content-Transfer-Encoding: Binary"); 
      header("Content-disposition: inline; filename=\"" . basename($file_url) . "\""); 
      ob_clean();
      flush();
      $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false
            )
        );

        if (readfile($file_url,false,stream_context_create($arrContextOptions))) 
        {
          
        }  
      
    }
    else
    {
      echo "Requested Document Not Found!!";
    }
  }

  


  public function view_image($Reference='Properties',$ReferenceId=0, $FileName='')
  {
    if($this->session->userdata('logged_in'))
      {
        $file = "uploads/$Reference/$ReferenceId/$FileName";
        if (file_exists($file))
        {
           header('Content-Type: '.get_mime_by_extension($file));
           readfile($file);
        } 
      }
  }


  public function UploadDocuments_old($Reference = 'Properties', $ReferenceId = 0)
  {
    $Message        = '';
    $Response['Status'] = false;
    $Reference      = ($Reference)?$Reference:$this->input->post('txtReferenceType');
    $ReferenceName  = $this->input->post('txtReference');
    $ReferenceId    = ($ReferenceId)?$ReferenceId:$this->input->post('txtReferenceId');
    $varNow         = date('Y-m-d H:i:s');
    $AdminId        = $this->session->userdata('user_id');
    $AdminName      = $this->session->userdata('user_name');
    $StationId      = $this->session->userdata('user_station');

    $uploadDir = "uploads/$Reference/$ReferenceId";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
        copy('uploads/index.php', "$uploadDir/index.php");
    }

    $this->load->library('upload');
    $uploadSuccess = false;

    $fileInputs = ['imageFile', 'videoFile'];

    foreach ($fileInputs as $fileInputName) {
        if (!isset($_FILES[$fileInputName]['name'])) {
            continue;
        }

        $files = $_FILES[$fileInputName];
        $count = count($files['name']);

        for ($i = 0; $i < $count; $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                continue;
            }

            $config = [
                'upload_path'   => $uploadDir . '/',
                'allowed_types' => '*',
                'max_size'      => 3000000,
                'encrypt_name'  => false,
                'remove_spaces' => true,
                'file_name'     => time() . mt_rand()
            ];

            $_FILES['file_temp']['name']     = $files['name'][$i];
            $_FILES['file_temp']['type']     = $files['type'][$i];
            $_FILES['file_temp']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['file_temp']['error']    = $files['error'][$i];
            $_FILES['file_temp']['size']     = $files['size'][$i];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file_temp')) {
                $fileData = $this->upload->data();

                $this->db->insert('tbl_property_media', [
                    'ReferenceId'   => $ReferenceId,
                    'Reference'     => ucwords(str_replace("_", " ", $Reference)),
                    'ReferenceName' => $ReferenceName,
                    'StationId'     => $StationId,
                    'FileName'      => $fileData['file_name'],
                    'FileSize'      => $fileData['file_size'],
                    'DocumentTitle' => $files['name'][$i],
                    'UploadedBy'    => $AdminId,
                    'UploadTime'    => $varNow
                ]);

                $uploadSuccess = true;
            }
        }
    }

    if ($uploadSuccess) {
        $Response['Status'] = true;
        $Response['Message'] = 'Files uploaded successfully';
    }
    $Response['PropertyId'] = $ReferenceId;
    $Response['NextTab'] = 'btnDashboard';

    exit(json_encode($Response));
  }

  

  // ===== Haseeb code below ====== //


  public function UploadDocuments($Reference = 'Properties', $ReferenceId = 0)
  {
      $Message        = '';
      $Response['Status'] = false;
      $Reference      = ($Reference)?$Reference:$this->input->post('txtReferenceType');
      $ReferenceId    = ($ReferenceId)?$ReferenceId:$this->input->post('txtReferenceId');
      $varNow         = date('Y-m-d H:i:s');
      $AdminId        = $this->session->userdata('user_id');
      $AdminName      = $this->session->userdata('user_name');
      $StationId      = $this->session->userdata('user_station')??'9';

      $image_upload = false;
      $video_upload = false;

      $image_upload = $this->ImageUpload($Reference, $ReferenceId);
      $video_upload = $this->VideoUpload($Reference, $ReferenceId);

      if($image_upload && $video_upload)
      {
          $Response['Status'] = true;
          $Response['Message'] = 'Files uploaded successfully'; 
      }

      $Response['PropertyId'] = $ReferenceId;
      
      $Response['NextTab'] = 'btnDocuments';

      exit(json_encode($Response));

  }

  public function ImageUpload($Reference = 'Properties', $ReferenceId = 0): bool
  {   

      $Reference      = ($Reference)?$Reference:$this->input->post('txtReferenceType');
      $ReferenceId    = ($ReferenceId)?$ReferenceId:$this->input->post('txtReferenceId');
      $varNow         = date('Y-m-d H:i:s');
      $AdminId        = $this->session->userdata('user_id');
      $AdminName      = $this->session->userdata('user_name');
      $StationId      = $this->session->userdata('user_station')??'9';
      $ImagePath = "uploads/$Reference/$ReferenceId/images";
      $uploadDir = FCPATH . $ImagePath;

      if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0777, true);
      }

      if (!is_writable($uploadDir)) {
          return false;
      }

      $this->load->library('upload');
      $image_upload = true;

      $images_count = count($_FILES['images']['name'] ?? []);

      for ($i = 0; $i < $images_count; $i++) {
          if (empty($_FILES['images']['name'][$i])) continue;
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

          if ($this->upload->do_upload('file')) {
              $fileData = $this->upload->data();
              $this->db->insert('tbl_property_media', [
                'PropertyId'    => $ReferenceId,
                'FileName'      => $fileData['file_name'],
                'FileSize'      => $fileData['file_size'],
                'MediaType'     => 'Image',
                'UploadedBy'    => $AdminId,
                'UploadTime'    => $varNow
              ]);
          } else {
              $image_upload = false;
          }
      }

      return $image_upload;
  }



  function VideoUpload($Reference = 'Properties', $ReferenceId = 0): bool
  {
      $Reference      = ($Reference)?$Reference:$this->input->post('txtReferenceType');
      $ReferenceName  = 'Properties';
      $ReferenceId    = ($ReferenceId)?$ReferenceId:$this->input->post('txtReferenceId');
      $varNow         = date('Y-m-d H:i:s');
      $AdminId        = $this->session->userdata('user_id');
      $AdminName      = $this->session->userdata('user_name');
      $StationId      = $this->session->userdata('user_station')??'9';
      $VideoPath = "uploads/$Reference/$ReferenceId/videos";
      $uploadDir = FCPATH . $VideoPath;

      if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0777, true);
      }

      if (!is_writable($uploadDir)) {
          return false;
      }

      $this->load->library('upload');
      $video_upload = true;

      $videos_count = count($_FILES['videos']['name'] ?? []);

      for ($i = 0; $i < $videos_count; $i++) {
          if (empty($_FILES['videos']['name'][$i])) continue;
          $_FILES['file']['name']     = $_FILES['videos']['name'][$i];
          $_FILES['file']['type']     = $_FILES['videos']['type'][$i];
          $_FILES['file']['tmp_name'] = $_FILES['videos']['tmp_name'][$i];
          $_FILES['file']['error']    = $_FILES['videos']['error'][$i];
          $_FILES['file']['size']     = $_FILES['videos']['size'][$i];

          $config = [
              'upload_path'   => $uploadDir,
              'allowed_types' => '*',
              'max_size'      => 50000000000, // in KB
              'encrypt_name'  => true,
          ];

          $this->upload->initialize($config);

          if ($this->upload->do_upload('file')) {
              $fileData = $this->upload->data();
              $this->db->insert('tbl_property_media', [
                'PropertyId'    => $ReferenceId,
                'FileName'      => $fileData['file_name'],
                'FileSize'      => $fileData['file_size'],
                'MediaType'     => 'Video',
                'UploadedBy'    => $AdminId,
                'UploadTime'    => $varNow
              ]);
          } else {
              $video_upload = false;
          }
      }

      return $video_upload;
  }


  public function DeleteDocument($DocumentId = 0)
  {
      $Response['Status'] = false;
      if ($DocumentId > 0) {
          $this->db->where('MediaId', $DocumentId);
          $this->db->delete('tbl_property_media');
          if($this->db->affected_rows() > 0) {
              $Response['Status'] = true;
          }
      }
      exit(json_encode($Response));
  }

}

