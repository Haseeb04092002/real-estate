<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        // $this->load->model('getlist_model'); // Load models as needed
    }

    public function index() {
        redirect('Admin/login');
    }

    public function login() {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('Admin/dashboard');
        }

        if ($this->input->post()) {
            $password = $this->input->post('password');
            if ($password === 'admin123') {
                $this->session->set_userdata('admin_logged_in', true);
                redirect('Admin/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid password.');
                redirect('Admin/login');
            }
        }

        $this->load->view('admin/login');
    }

    public function logout() {
        $this->session->unset_userdata('admin_logged_in');
        redirect('Admin/login');
    }

    private function check_auth() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('Admin/login');
        }
    }

    public function dashboard() {
        $this->check_auth();
        $data['page_title'] = 'Dashboard';
        $this->load->view('admin/dashboard', $data);
    }

    public function user_management() {
        $this->check_auth();
        $data['page_title'] = 'User Management';
        $this->load->model('Admin_User_Model');
        $data['users'] = $this->Admin_User_Model->get_all_users();
        $this->load->view('admin/user_management', $data);
    }

    public function user_details($user_id) {
        $this->check_auth();
        if(!$user_id) redirect('Admin/user_management');
        $this->load->model('Admin_User_Model');
        $this->load->model('Admin_User_Verifications_Model');
        $data = $this->Admin_User_Model->get_user_details($user_id);
        if(!$data || !$data['user']) redirect('Admin/user_management');
        $data['page_title'] = 'User Details';
        $data['verification_rules'] = $this->Admin_User_Verifications_Model->get_rules();
        $this->load->view('admin/user_details', $data);
    }

    public function api_get_user_details() {
        $this->check_auth();
        $user_id = $this->input->post('user_id');
        if(!$user_id) { echo json_encode(['error'=>'No ID']); return; }
        $this->load->model('Admin_User_Model');
        $data = $this->Admin_User_Model->get_user_details($user_id);
        echo json_encode($data);
    }

    public function api_update_user_status() {
        $this->check_auth();
        $user_id = $this->input->post('user_id');
        $status = $this->input->post('status');
        $reason = $this->input->post('reason');
        $this->load->model('Admin_User_Model');
        $this->Admin_User_Model->update_user_status($user_id, $status, $reason);
        echo json_encode(['success' => true]);
    }

    public function api_update_document_status() {
        $this->check_auth();
        $doc_id = $this->input->post('document_id');
        $status = $this->input->post('status');
        if($doc_id && $status) {
            $this->db->where('DocumentId', $doc_id)->update('tbl_documents', ['VerificationStatus' => $status]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    // --- PROPERTY MANAGEMENT MODULE ---
    public function property_management() {
        $this->check_auth();
        $this->load->model('Admin_Property_Model');
        $data['page_title'] = 'Property Ownership Monitoring';
        $data['properties'] = $this->Admin_Property_Model->get_all_properties_with_ownership();
        $this->load->view('admin/properties_management', $data);
    }

    public function api_update_property_status() {
        $this->check_auth();
        $this->load->model('Admin_Property_Model');
        $property_id = $this->input->post('property_id');
        $status = $this->input->post('status');
        
        if ($property_id && $status) {
            $success = $this->Admin_Property_Model->update_property_status($property_id, $status);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Missing parameters']);
        }
    }

    public function property_details($property_id) {
        $this->check_auth();
        $this->load->model('Admin_Property_Model');
        $data['property'] = $this->Admin_Property_Model->get_property_details($property_id);
        
        if (!$data['property']) {
            redirect('Admin/property_management');
        }

        $data['page_title'] = 'Edit Property';
        $data['property_types'] = $this->Admin_Property_Model->get_all_property_types();
        $data['cities'] = $this->Admin_Property_Model->get_all_cities();
        $data['features'] = $this->Admin_Property_Model->get_property_features($property_id);
        $data['media'] = $this->Admin_Property_Model->get_property_media($property_id);
        
        $this->load->view('admin/property_details', $data);
    }

    public function api_save_property_details() {
        $this->check_auth();
        $this->load->model('Admin_Property_Model');
        
        $property_id = $this->input->post('PropertyId');
        if (!$property_id) {
            echo json_encode(['success' => false, 'message' => 'Property ID is required']);
            return;
        }

        $data = [
            'PropertyTitle' => $this->input->post('PropertyTitle'),
            'PropertyDescription' => $this->input->post('PropertyDescription'),
            'PropertyStatus' => $this->input->post('PropertyStatus'),
            'ListType' => $this->input->post('ListType'),
            'TotalPrice' => $this->input->post('TotalPrice'),
            'PropertyTypeId' => $this->input->post('PropertyTypeId'),
            'CityId' => $this->input->post('CityId'),
            'Rooms' => $this->input->post('Rooms'),
            'BathRooms' => $this->input->post('BathRooms'),
            'CoveredArea' => $this->input->post('CoveredArea'),
            'MailingAddress' => $this->input->post('MailingAddress'),
            'StreetName' => $this->input->post('StreetName'),
            'StreetNumber' => $this->input->post('StreetNumber'),
            'BuildingNumber' => $this->input->post('BuildingNumber'),
            'ZipCode' => $this->input->post('ZipCode'),
            'UpdatedOn' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('user_id')
        ];

        $success = $this->Admin_Property_Model->update_property($property_id, $data);

        $features_data = [
            'BuiltInYear' => $this->input->post('BuiltInYear'),
            'ParkingSpaces' => $this->input->post('ParkingSpaces'),
            'Floors' => $this->input->post('Floors'),
            'Bedrooms' => $this->input->post('Bedrooms'),
            'Bathrooms' => $this->input->post('Bathrooms_feature'), // map form name
            'OtherRooms' => $this->input->post('OtherRooms'),
            'ServantQuarters' => $this->input->post('ServantQuarters'),
            'Kitchens' => $this->input->post('Kitchens'),
            'StoreRooms' => $this->input->post('StoreRooms'),
            
            // Boolean fields (checkboxes send '1' if checked, else null)
            'IsDoubleGlazedWindows' => $this->input->post('IsDoubleGlazedWindows') ? 1 : 0,
            'IsCentralAirConditioning' => $this->input->post('IsCentralAirConditioning') ? 1 : 0,
            'IsCentralHeating' => $this->input->post('IsCentralHeating') ? 1 : 0,
            'IsWasteDisposal' => $this->input->post('IsWasteDisposal') ? 1 : 0,
            'IsFurnished' => $this->input->post('IsFurnished') ? 1 : 0,
            'IsDrawingRoom' => $this->input->post('IsDrawingRoom') ? 1 : 0,
            'IsDiningRoom' => $this->input->post('IsDiningRoom') ? 1 : 0,
            'IsStudyRoom' => $this->input->post('IsStudyRoom') ? 1 : 0,
            'IsPrayerRoom' => $this->input->post('IsPrayerRoom') ? 1 : 0,
            'IsPowderRoom' => $this->input->post('IsPowderRoom') ? 1 : 0,
            'IsGym' => $this->input->post('IsGym') ? 1 : 0,
            'IsSteamRoom' => $this->input->post('IsSteamRoom') ? 1 : 0,
            'IsLoungeRoom' => $this->input->post('IsLoungeRoom') ? 1 : 0,
            'IsLaundryRoom' => $this->input->post('IsLaundryRoom') ? 1 : 0,
            'IsBroadbandInternetAccess' => $this->input->post('IsBroadbandInternetAccess') ? 1 : 0,
            'IsTVReady' => $this->input->post('IsTVReady') ? 1 : 0,
            'IsIntercom' => $this->input->post('IsIntercom') ? 1 : 0,
            'IsConferenceRoom' => $this->input->post('IsConferenceRoom') ? 1 : 0,
            'IsCommunityLawn' => $this->input->post('IsCommunityLawn') ? 1 : 0,
            'IsCommunitySwimmingPool' => $this->input->post('IsCommunitySwimmingPool') ? 1 : 0,
            'IsCommunityGym' => $this->input->post('IsCommunityGym') ? 1 : 0,
            'IsFirstAid' => $this->input->post('IsFirstAid') ? 1 : 0,
            'IsDayCareCenter' => $this->input->post('IsDayCareCenter') ? 1 : 0,
            'IsKidsPlayArea' => $this->input->post('IsKidsPlayArea') ? 1 : 0,
            'IsBarbequeArea' => $this->input->post('IsBarbequeArea') ? 1 : 0,
            'IsMosque' => $this->input->post('IsMosque') ? 1 : 0,
            'IsCommunityCentre' => $this->input->post('IsCommunityCentre') ? 1 : 0,
            'IsLawnGarden' => $this->input->post('IsLawnGarden') ? 1 : 0,
            'IsSwimmingPool' => $this->input->post('IsSwimmingPool') ? 1 : 0,
            'IsSauna' => $this->input->post('IsSauna') ? 1 : 0,
            'IsJacuzzi' => $this->input->post('IsJacuzzi') ? 1 : 0,
        ];
        
        $this->Admin_Property_Model->update_property_features($property_id, $features_data);

        echo json_encode(['success' => $success]);
    }

    // --- ADS MANAGEMENT MODULE ---

    public function ads_management() {
        $this->check_auth();
        $this->load->model('Admin_Ads_Model');
        
        $data['page_title'] = 'Ads Management';
        $data['stats'] = $this->Admin_Ads_Model->get_ads_stats();
        
        $this->load->view('admin/ads_management', $data);
    }

    public function api_get_ads() {
        $this->check_auth();
        $this->load->model('Admin_Ads_Model');
        $status = $this->input->get('status');
        if ($status === 'all') $status = null;
        
        $ads = $this->Admin_Ads_Model->get_all_ads($status);
        echo json_encode(['data' => $ads]);
    }

    public function api_save_ad() {
        $this->check_auth();
        $this->load->model('Admin_Ads_Model');
        
        $ad_id = $this->input->post('AdId');
        
        $data = [
            'Title' => $this->input->post('Title'),
            'AdType' => $this->input->post('AdType'),
            'ReferenceId' => $this->input->post('ReferenceId') ?: null,
            'TargetUrl' => $this->input->post('TargetUrl'),
            'StartDate' => $this->input->post('StartDate'),
            'EndDate' => $this->input->post('EndDate'),
            'Status' => $this->input->post('Status')
        ];

        // Handle Image Upload
        if (!empty($_FILES['ImageFile']['name'])) {
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
            $config['max_size']      = 5120;
            $config['encrypt_name']  = TRUE;
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('ImageFile')) {
                $upload_data = $this->upload->data();
                $data['ImagePath'] = $upload_data['file_name'];
            } else {
                echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
                return;
            }
        }

        if ($ad_id) {
            $data['UpdatedOn'] = date('Y-m-d H:i:s');
            $success = $this->Admin_Ads_Model->update_ad($ad_id, $data);
        } else {
            $success = $this->Admin_Ads_Model->create_ad($data);
        }

        echo json_encode(['success' => $success]);
    }

    public function api_update_ad_status() {
        $this->check_auth();
        $this->load->model('Admin_Ads_Model');
        $ad_id = $this->input->post('AdId');
        $status = $this->input->post('Status');
        
        if ($ad_id && $status) {
            $success = $this->Admin_Ads_Model->update_ad_status($ad_id, $status);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function api_delete_ad() {
        $this->check_auth();
        $this->load->model('Admin_Ads_Model');
        $ad_id = $this->input->post('AdId');
        
        if ($ad_id) {
            $success = $this->Admin_Ads_Model->delete_ad($ad_id);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    // --- CONTRACT MANAGEMENT MODULE ---
    public function contract_types() {
        $this->check_auth();
        $this->load->model('Admin_Contract_Model');
        $data['page_title'] = 'Contract Types';
        $data['active_tab'] = 'types';
        $data['types'] = $this->Admin_Contract_Model->get_contract_types();
        $this->load->view('admin/contracts/types', $data);
    }

    public function contract_templates() {
        $this->check_auth();
        $this->load->model('Admin_Contract_Model');
        $data['page_title'] = 'Contract Templates';
        $data['active_tab'] = 'templates';
        $data['templates'] = $this->Admin_Contract_Model->get_contract_templates();
        $data['types'] = $this->Admin_Contract_Model->get_contract_types();
        $data['clauses'] = $this->Admin_Contract_Model->get_legal_clauses();
        $data['variables'] = $this->Admin_Contract_Model->get_contract_variables();
        $this->load->view('admin/contracts/templates', $data);
    }

    public function contract_clauses() {
        $this->check_auth();
        $this->load->model('Admin_Contract_Model');
        $data['page_title'] = 'Legal Clauses';
        $data['active_tab'] = 'clauses';
        $data['clauses'] = $this->Admin_Contract_Model->get_legal_clauses();
        $this->load->view('admin/contracts/clauses', $data);
    }

    public function generated_contracts() {
        $this->check_auth();
        $this->load->model('Admin_Contract_Model');
        $data['page_title'] = 'Generated Contracts';
        $data['active_tab'] = 'generated';
        $data['contracts'] = $this->Admin_Contract_Model->get_generated_contracts();
        $this->load->view('admin/contracts/list', $data);
    }

    public function contract_management() {
        $this->check_auth();
        $this->load->model('Admin_Contract_Model');
        $data['page_title'] = 'Contract Management';
        $data['active_tab'] = 'analytics';
        $data['analytics'] = $this->Admin_Contract_Model->get_analytics();
        $this->load->view('admin/contracts/analytics', $data);
    }

    // API endpoints for contracts
    public function api_save_contract_type() {
        $this->check_auth();
        $this->load->model('Admin_Contract_Model');
        $id = $this->input->post('TypeId');
        $data = [
            'Title' => $this->input->post('Title'),
            'IsActive' => $this->input->post('IsActive')
        ];
        if(!$id) {
            $data['AddedOn'] = date('Y-m-d H:i:s');
            $data['AddedBy'] = $this->session->userdata('user_id');
        } else {
            $data['UpdatedOn'] = date('Y-m-d H:i:s');
            $data['UpdatedBy'] = $this->session->userdata('user_id');
        }
        $this->Admin_Contract_Model->save_contract_type($data, $id);
        redirect('Admin/contract_types');
    }

    public function api_save_template() {
        $this->check_auth();
        $this->load->model('Admin_Contract_Model');
        $id = $this->input->post('TemplateId');
        $data = [
            'ContractTypeId' => $this->input->post('ContractTypeId'),
            'TemplateTitle' => $this->input->post('TemplateTitle'),
            'TemplateContent' => $this->input->post('TemplateContent', FALSE), // allow html
            'Status' => $this->input->post('Status')
        ];
        if(!$id) {
            $data['AddedOn'] = date('Y-m-d H:i:s');
            $data['AddedBy'] = $this->session->userdata('user_id');
        } else {
            $data['UpdatedOn'] = date('Y-m-d H:i:s');
            $data['UpdatedBy'] = $this->session->userdata('user_id');
            // Versioning could increment here
        }
        $this->Admin_Contract_Model->save_contract_template($data, $id);
        redirect('Admin/contract_templates');
    }

    public function api_save_clause() {
        $this->check_auth();
        $this->load->model('Admin_Contract_Model');
        $id = $this->input->post('ClauseId');
        $data = [
            'ClauseTitle' => $this->input->post('ClauseTitle'),
            'ClauseContent' => $this->input->post('ClauseContent')
        ];
        if(!$id) {
            $data['AddedOn'] = date('Y-m-d H:i:s');
            $data['AddedBy'] = $this->session->userdata('user_id');
        }
        $this->Admin_Contract_Model->save_legal_clause($data, $id);
        redirect('Admin/contract_clauses');
    }

    public function api_update_contract_status() {
        $this->check_auth();
        $this->load->model('Admin_Contract_Model');
        $id = $this->input->post('ContractId');
        $status = $this->input->post('Status');
        if($id && $status) {
            $this->Admin_Contract_Model->update_contract_status($id, $status);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function contract_pdf($contract_id) {
        $this->check_auth();
        $this->load->model('Admin_Contract_Model');
        $contract = $this->Admin_Contract_Model->get_contract($contract_id);
        if(!$contract) redirect('Admin/generated_contracts');
        
        // This relies on Dompdf. Since Properties.php already uses it, we know it's available.
        require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        
        $html = "<html><body>";
        $html .= "<h2>Contract #" . $contract->ContractId . " - " . $contract->TypeTitle . "</h2>";
        $html .= "<hr>";
        $html .= $contract->ContractHTML;
        $html .= "</body></html>";

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Contract_".$contract->ContractId.".pdf", ["Attachment" => true]);
    }

    public function blogs_management() {
        $this->check_auth();
        $data['page_title'] = 'Blogs Management';
        $this->load->view('admin/blogs_management', $data);
    }

    public function api_get_blogs() {
        $this->check_auth();
        $this->load->model('Admin_Blogs_Model');
        $blogs = $this->Admin_Blogs_Model->get_all_blogs();
        echo json_encode(['data' => $blogs]);
    }

    public function api_save_blog() {
        $this->check_auth();
        $this->load->model('Admin_Blogs_Model');

        $id = $this->input->post('BlogId');
        $data = [
            'Title' => $this->input->post('Title'),
            'Description' => $this->input->post('Description'),
            'Content' => $this->input->post('Content'),
            'Status' => $this->input->post('Status')
        ];

        // Handle File Upload
        if (!empty($_FILES['BlogImage']['name'])) {
            $config['upload_path'] = FCPATH . 'uploads/blogs/';
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('BlogImage')) {
                $uploadData = $this->upload->data();
                $data['ImageName'] = $uploadData['file_name'];
                
                // If editing and uploading new image, delete old one
                if ($id) {
                    $old_blog = $this->Admin_Blogs_Model->get_blog_by_id($id);
                    if ($old_blog && $old_blog->ImageName) {
                        $old_path = $config['upload_path'] . $old_blog->ImageName;
                        if (file_exists($old_path)) unlink($old_path);
                    }
                }
            }
        }

        if ($id) {
            $this->Admin_Blogs_Model->update_blog($id, $data);
        } else {
            // Ensure ImageName exists on create
            if(!isset($data['ImageName'])) $data['ImageName'] = 'default.jpg';
            $this->Admin_Blogs_Model->insert_blog($data);
        }
        echo json_encode(['success' => true]);
    }

    public function api_update_blog_status() {
        $this->check_auth();
        $id = $this->input->post('BlogId');
        $status = $this->input->post('Status');
        $this->load->model('Admin_Blogs_Model');
        $this->Admin_Blogs_Model->update_status($id, $status);
        echo json_encode(['success' => true]);
    }

    public function api_delete_blog() {
        $this->check_auth();
        $id = $this->input->post('BlogId');
        $this->load->model('Admin_Blogs_Model');
        $this->Admin_Blogs_Model->delete_blog($id);
        echo json_encode(['success' => true]);
    }

    // --- CONTRACT VARIABLES ---
    public function api_save_contract_variable() {
        $this->check_auth();
        $this->load->model('Admin_Contract_Model');
        
        $varKey = $this->input->post('VarKey');
        // Clean VarKey to remove brackets and spaces
        $varKey = str_replace(['{', '}', ' '], ['', '', '_'], $varKey);
        
        if (!empty($varKey)) {
            $data = [
                'VarKey' => $varKey,
                'AddedOn' => date('Y-m-d H:i:s'),
                'AddedBy' => $this->session->userdata('user_id')
            ];
            $this->Admin_Contract_Model->save_contract_variable($data);
        }
        
        redirect('Admin/contract_templates');
    }

    public function run_migration() {
        $sql = "CREATE TABLE IF NOT EXISTS tbl_contract_variables (
            VarId INT AUTO_INCREMENT PRIMARY KEY,
            VarKey VARCHAR(255) NOT NULL,
            AddedOn DATETIME NOT NULL,
            AddedBy INT NULL
        )";
        $this->db->query($sql);
        
        $count = $this->db->count_all('tbl_contract_variables');
        if ($count == 0) {
            $defaults = ['buyer_name', 'seller_name', 'property_title', 'property_address', 'property_price', 'advance_amount', 'remaining_amount', 'contract_date', 'property_area', 'city'];
            foreach ($defaults as $v) {
                $this->db->insert('tbl_contract_variables', ['VarKey' => $v, 'AddedOn' => date('Y-m-d H:i:s')]);
            }
        }
        echo "Migration ran successfully.";
    }

}
