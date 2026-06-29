<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Allow only CLI requests
        if (!is_cli()) {
            echo "This script can only be accessed via the command line.\n";
            exit;
        }
        $this->load->database();
        $this->load->model('Admin_Property_Docs_Model');
    }

    public function index() {
        echo "Cron Job Controller.\nUsage: php index.php cron check_expiries\n";
    }

    public function check_expiries() {
        echo "Running document expiry check...\n";
        
        // Find documents with ExpiryDate set and not completely expired notification sent
        $this->db->select('d.*, t.DocumentTitle, t.RequiresExpiryTracking, p.PropertyTitle, c.ClientName, c.EmailAddress');
        $this->db->from('tbl_property_documents d');
        $this->db->join('tbl_property_document_types t', 'd.DocTypeId = t.DocTypeId');
        $this->db->join('tbl_properties p', 'd.PropertyId = p.PropertyId');
        $this->db->join('tbl_clients c', 'd.SellerId = c.ClientId');
        $this->db->where('d.ExpiryDate IS NOT NULL');
        $this->db->where('t.RequiresExpiryTracking', 1);
        $this->db->where('d.NotificationStatus !=', 'Expired');
        $documents = $this->db->get()->result();

        $today = new DateTime();
        $today->setTime(0, 0, 0);

        foreach ($documents as $doc) {
            $expiry = new DateTime($doc->ExpiryDate);
            $expiry->setTime(0, 0, 0);
            
            $interval = $today->diff($expiry);
            $daysLeft = (int)$interval->format('%R%a'); // e.g. +90, -1

            $newStatus = $doc->NotificationStatus;
            
            if ($daysLeft <= 0 && $doc->NotificationStatus != 'Expired') {
                $newStatus = 'Expired';
                $this->suspend_property($doc->PropertyId, $doc->DocumentTitle);
                $this->send_expiry_email($doc->EmailAddress, $doc->ClientName, $doc->PropertyTitle, $doc->DocumentTitle, 0);
            } 
            elseif ($daysLeft <= 7 && $daysLeft > 0 && !in_array($doc->NotificationStatus, ['7', 'Expired'])) {
                $newStatus = '7';
                $this->send_expiry_email($doc->EmailAddress, $doc->ClientName, $doc->PropertyTitle, $doc->DocumentTitle, $daysLeft);
            }
            elseif ($daysLeft <= 30 && $daysLeft > 7 && !in_array($doc->NotificationStatus, ['30', '7', 'Expired'])) {
                $newStatus = '30';
                $this->send_expiry_email($doc->EmailAddress, $doc->ClientName, $doc->PropertyTitle, $doc->DocumentTitle, $daysLeft);
            }
            elseif ($daysLeft <= 90 && $daysLeft > 30 && !in_array($doc->NotificationStatus, ['90', '30', '7', 'Expired'])) {
                $newStatus = '90';
                $this->send_expiry_email($doc->EmailAddress, $doc->ClientName, $doc->PropertyTitle, $doc->DocumentTitle, $daysLeft);
            }

            if ($newStatus != $doc->NotificationStatus) {
                $this->db->where('DocumentId', $doc->DocumentId)->update('tbl_property_documents', ['NotificationStatus' => $newStatus]);
                echo "Updated Document ID {$doc->DocumentId} to {$newStatus} notification status.\n";
            }
        }

        echo "Expiry check completed.\n";
    }

    private function suspend_property($propertyId, $docTitle) {
        // Change property status to hidden/suspended due to expired mandatory doc
        // Assuming there is a status we can set, e.g., 'vacant' or an IsSuspended flag.
        // For now we set IsDeleted = 2 (Suspended) as an example, adjust as per actual schema.
        $this->db->where('PropertyId', $propertyId)->update('tbl_properties', ['IsDeleted' => 2]);
        echo "Suspended Property ID {$propertyId} due to expired {$docTitle}.\n";
    }

    private function send_expiry_email($email, $name, $propTitle, $docTitle, $days) {
        // Mock email sending
        if ($days <= 0) {
            echo "EMAIL SENT to {$email}: Your document '{$docTitle}' for '{$propTitle}' has EXPIRED. Listing suspended.\n";
        } else {
            echo "EMAIL SENT to {$email}: Your document '{$docTitle}' for '{$propTitle}' will expire in {$days} days.\n";
        }
    }
}
