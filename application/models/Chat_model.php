<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get or create a conversation for a specific property between buyer and seller.
     */
    public function get_or_create_conversation($property_id, $buyer_id, $seller_id) {
        $this->db->where('property_id', $property_id);
        $this->db->where('buyer_id', $buyer_id);
        $this->db->where('seller_id', $seller_id);
        $query = $this->db->get('chat_conversations');

        if ($query->num_rows() > 0) {
            return $query->row()->id;
        }

        $data = [
            'property_id' => $property_id,
            'buyer_id' => $buyer_id,
            'seller_id' => $seller_id
        ];
        $this->db->insert('chat_conversations', $data);
        return $this->db->insert_id();
    }

    /**
     * Save a new message.
     */
    public function save_message($conversation_id, $sender_id, $message_text) {
        $data = [
            'conversation_id' => $conversation_id,
            'sender_id' => $sender_id,
            'message' => $message_text,
            'status' => 'Sent'
        ];
        $this->db->insert('chat_messages', $data);
        $message_id = $this->db->insert_id();

        // Update the conversation's latest message and updated_at timestamp
        $this->db->where('id', $conversation_id);
        $this->db->update('chat_conversations', [
            'latest_message_id' => $message_id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $message_id;
    }

    /**
     * Mark all messages in a conversation as read by the receiver.
     */
    public function mark_messages_read($conversation_id, $user_id) {
        $this->db->where('conversation_id', $conversation_id);
        $this->db->where('sender_id !=', $user_id);
        $this->db->where('status !=', 'Read');
        $this->db->update('chat_messages', ['status' => 'Read']);
    }

    /**
     * Fetch conversation list for a user.
     */
    public function get_user_conversations($user_id) {
        $sql = "
            SELECT c.*, 
                   m.message AS latest_message, 
                   m.created_at AS latest_message_time,
                   IF(c.buyer_id = ?, c.seller_id, c.buyer_id) AS other_user_id,
                   (SELECT COUNT(id) FROM chat_messages WHERE conversation_id = c.id AND sender_id != ? AND status != 'Read') AS unread_count
            FROM chat_conversations c
            LEFT JOIN chat_messages m ON c.latest_message_id = m.id
            WHERE c.buyer_id = ? OR c.seller_id = ?
            ORDER BY c.updated_at DESC
        ";
        return $this->db->query($sql, [$user_id, $user_id, $user_id, $user_id])->result();
    }

    /**
     * Fetch messages for a specific conversation.
     */
    public function get_messages($conversation_id, $limit = 50, $offset = 0) {
        $this->db->where('conversation_id', $conversation_id);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $offset);
        return $this->db->get('chat_messages')->result();
    }
}
