<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_Chat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Chat_model');
        $this->load->helper('jwt');
        
        // Ensure user is logged in
        // if (!$this->session->userdata('user_id')) {
        //     echo json_encode(['error' => 'Unauthorized']);
        //     exit;
        // }
    }

    /**
     * Get a JWT token for the currently authenticated user to connect to Socket.IO
     */
    public function get_token() {
        // For demonstration, hardcode user_id if session is empty.
        // In production, use $this->session->userdata('user_id')
        $user_id = $this->session->userdata('user_id') ?: 1; 
        
        $payload = [
            'user_id' => $user_id,
            'exp' => time() + (60 * 60 * 24) // 1 day
        ];
        
        // Using the jwt_helper we created
        $token = generate_jwt($payload, 'FRE_REALESTATE_SECRET_KEY_123');
        
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'token' => $token,
            'user_id' => $user_id
        ]);
    }

    /**
     * Send a message to another user.
     */
    public function send_message() {
        $sender_id = $this->session->userdata('user_id') ?: 1; // Sender (Current User)
        
        $receiver_id = $this->input->post('receiver_id');
        $property_id = $this->input->post('property_id');
        $message_text = $this->input->post('message');

        if (!$receiver_id || !$property_id || empty($message_text)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
            return;
        }

        // 1. Get or Create Conversation (always Buyer first, Seller second - logic depends on who is who, simplify here)
        // Note: You need logic to determine who is buyer and who is seller. We assume sender is buyer and receiver is seller for this example.
        $conv_id = $this->Chat_model->get_or_create_conversation($property_id, $sender_id, $receiver_id);
        
        // 2. Save Message to MySQL
        $msg_id = $this->Chat_model->save_message($conv_id, $sender_id, $message_text);
        
        // 3. Notify Node.js Server via Internal API (Server-to-Server request)
        $this->_notify_node_server('new_message', [
            'message_id' => $msg_id,
            'conversation_id' => $conv_id,
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $message_text,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message_id' => $msg_id, 'conversation_id' => $conv_id]);
    }

    /**
     * Mark all messages in a conversation as read.
     */
    public function mark_read() {
        $conversation_id = $this->input->post('conversation_id');
        $user_id = $this->session->userdata('user_id') ?: 1;
        
        if (!$conversation_id) {
            echo json_encode(['status' => 'error', 'message' => 'Missing conversation_id']);
            return;
        }

        // Update DB
        $this->Chat_model->mark_messages_read($conversation_id, $user_id);
        
        // You would need to know the sender_id of the other party to notify them.
        // For simplicity, assuming you pass the other party's ID
        $sender_id = $this->input->post('other_user_id'); 
        
        if ($sender_id) {
            // Notify sender via Node.js that their messages were read
            $this->_notify_node_server('messages_read', [
                'conversation_id' => $conversation_id,
                'reader_id' => $user_id,
                'sender_id' => $sender_id
            ]);
        }

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
    }

    /**
     * Helper to send HTTP POST to Node.js server
     */
    private function _notify_node_server($event, $data) {
        $url = 'http://127.0.0.1:3000/internal-api/emit';
        $payload = json_encode(['event' => $event, 'data' => $data]);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json', 
            'x-internal-secret: FRE_INTERNAL_SECRET_KEY_456'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2); // Short timeout so it doesn't block PHP
        
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
    }
}
