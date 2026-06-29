<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function send_email() {
        $name    = $this->input->post('txtName', true);
        $email   = $this->input->post('txtEmail', true);
        $message = $this->input->post('txtMessage', true);

        /* FORM VALIDATION */
        $this->form_validation->set_rules(
            'txtName',
            'Name',
            'required|min_length[3]|max_length[100]'
        );

        $this->form_validation->set_rules(
            'txtEmail',
            'Email Address',
            'required|valid_email|max_length[200]'
        );

        $this->form_validation->set_rules(
            'txtNumber',
            'Phone Number',
            'required|numeric|min_length[7]|max_length[15]'
        );

        $this->form_validation->set_rules(
            'txtMessage',
            'Message',
            'required|min_length[10]|max_length[1000]'
        );

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('msg', validation_errors());
            redirect('Properties/Contact');
            return;
        }

        // SMTP configuration
        $config = [
            'protocol'    => 'smtp',
            'smtp_host'   => 'smtp.hostinger.com',
            'smtp_port'   => 465,
            'smtp_user'   => 'web@jauntsolutions.com.au',
            'smtp_pass'   => 'Letmein786@#@',
            'smtp_crypto' => 'ssl',
            'mailtype'    => 'html',
            'charset'     => 'utf-8',
            'newline'     => "\r\n",
            'wordwrap'    => true
        ];

        $this->email->initialize($config);
        $this->email->set_newline("\r\n");

        $this->email->from('web@jauntsolutions.com.au', 'FRE Real Estate Website');
        $this->email->to('support@jauntsolutions.com');
        $this->email->cc('haseeb24hours@gmail.com');
        $this->email->subject('New Contact Message from '.$name);
        $this->email->message("
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ");

        if ($this->email->send()) {
            $this->session->set_flashdata('msg', 'Email sent successfully!');
        } else {
            $this->session->set_flashdata('msg', 'Email failed: ' . $this->email->print_debugger(['headers']));
        }

        redirect('Properties/Contact');
    }
}
