<?php
defined('BASEPATH') OR exit('No direct script access allowed');



// =================================================================
// =================================================================

// Client ID = 666843242869-p5lq0v10s820573ql40c1g7pgp4ggism.apps.googleusercontent.com

// Client secret = YOUR_CLIENT_SECRET_HERE

// =================================================================
// =================================================================


class Google_login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        require_once APPPATH . "third_party/google-api-php-client-v4/vendor/autoload.php";

    }

    private function getClient() {
        $client = new Google_Client();
        $client->setClientId("666843242869-p5lq0v10s820573ql40c1g7pgp4ggism.apps.googleusercontent.com");
        $client->setClientSecret("YOUR_CLIENT_SECRET_HERE");
        $client->setRedirectUri('http://properties.jauntsolutions.com/Google_login/callback');
        // $client->setRedirectUri("http://properties.jauntsolutions.com");
        $client->addScope("email");
        $client->addScope("profile");
        return $client;
    }

    // public function index() {
    //     $client = $this->getClient();
    //     $data['google_login_url'] = $client->createAuthUrl();
    //     $this->load->view('google_login', $data);
    // }

    public function index() {
        $client = $this->getClient();

        $client->setPrompt('select_account');

        redirect($client->createAuthUrl());
    }


    public function callback() {
        $client = $this->getClient();

        if ($this->input->get('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($this->input->get('code'));

            if (isset($token['error'])) {
                redirect('Properties/signin');
            }

            $client->setAccessToken($token);
            $google_service = new Google_Service_Oauth2($client);
            $google_info = $google_service->userinfo->get();

            // Get Google info
            $google_id    = $google_info->id;
            $user_name    = $google_info->name;
            $user_email   = $google_info->email;
            $user_picture = $google_info->picture;

            // echo "<br>google_id = ".$google_id;
            // echo "<br>user_name = ".$user_name;
            // echo "<br>user_email = ".$user_email;
            // echo "<br>user_picture = ".$user_picture;

            // die();

            // Check if user exists in DB
            $query = $this->db->get_where('tbl_clients', ['EmailAddress' => $user_email]);
            $user = $query->row();

            if (!$user) {
                // Register user if not exists
                // $encKey = $this->config->item('encryption_key');
                // $random_pass = bin2hex(random_bytes(6)); // auto-generate password
                $Password = '123456789';
                $insert_data = [
                    'ClientName'  => $user_name,
                    'EmailAddress'=> $user_email,
                    'Password'    => $this->encrypt->encode($Password,$encKey),
                    'StationId'   => 1,
                    'PhoneNumber' => ''
                ];

                $this->db->insert('tbl_clients', $insert_data);
                $user_id = $this->db->insert_id();

                // Fetch new user row
                $user = $this->db->get_where('tbl_clients', ['ClientId' => $user_id])->row();
            }

            // Set session for login
            $session_data = [
                'user_id'        => $user->ClientId,
                'user_email'     => $user->EmailAddress,
                'user_name'      => $user->ClientName,
                'user_thumb'     => $user_picture,
                'client_id'      => $user->ClientId,
                'client_name'    => $user->ClientName,
                'parent_station' => $user->StationParentId ?? '',
                'active_station' => $user->StationId,
                'user_station'   => $user->StationId??'1',
                'user_company'   => $user->CompanyId ?? '',
                'is_active'      => time(),
                'logo'           => '',
                'login_time'     => date("d-M-Y H:i:s"),
                'logged_in'      => true
            ];

            $this->session->set_userdata($session_data);

            // Redirect to home page
            redirect('Properties');
        } else {
            redirect('Properties/signin');
        }
    }
}
