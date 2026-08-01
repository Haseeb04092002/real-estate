# Real-Time Chat Architecture: CodeIgniter 3 + Node.js + Socket.IO

This document outlines a production-ready, scalable architecture for integrating a real-time messaging system into an existing CodeIgniter 3 application.

## 1. System Architecture Overview

The system strictly adheres to the principle of **Separation of Concerns**:
*   **CodeIgniter 3 (PHP & MySQL)**: Acts as the Source of Truth. Handles all business logic, database reads/writes, user authentication (via JWT), message persistence, and exposes REST API endpoints.
*   **Node.js (Express & Socket.IO)**: Acts strictly as the real-time transport layer. It validates the JWT to accept connections, manages socket rooms, and broadcasts real-time events to connected clients. It does *not* talk to the database directly.

### Event Flow
1. **Connect**: Client connects to Node.js with a JWT. Node verifies the JWT and adds the user to a unique socket room (e.g., `user_{id}`).
2. **Send Message**: Client sends a POST request to the CodeIgniter API.
3. **Persist**: CodeIgniter validates, saves the message in MySQL, and updates the conversation.
4. **Broadcast**: CodeIgniter triggers the Node.js server (via an internal HTTP POST or Redis Pub/Sub) with the new message payload.
5. **Deliver**: Node.js broadcasts the message to the recipient's socket room (`user_{recipient_id}`).

---

## 2. Database Schema (MySQL)

This schema supports 1-to-1 chats tied to a property, read receipts, and online status.

```sql
CREATE TABLE `chat_conversations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `latest_message_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_property_buyer_seller` (`property_id`,`buyer_id`,`seller_id`),
  KEY `idx_buyer` (`buyer_id`),
  KEY `idx_seller` (`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conversation_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Sent','Delivered','Read') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sent',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_conversation` (`conversation_id`),
  KEY `idx_sender` (`sender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `chat_user_status` (
  `user_id` int(11) NOT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  `last_seen` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 3. Folder Structure

```text
/your_ci3_project/
├── chat-server/                   # Node.js + Socket.IO Server
│   ├── package.json
│   ├── server.js
│   ├── .env                       # Stores JWT secret (shared with CI3)
│   └── middleware/
│       └── auth.js                # JWT verification
├── application/
│   ├── controllers/
│   │   ├── Api_Chat.php           # REST API Endpoints
│   ├── models/
│   │   └── Chat_model.php         # DB queries for conversations/messages
│   ├── views/
│   │   └── chat/
│   │       └── index.php          # Chat UI (Bootstrap 5)
├── assets/
│   ├── css/chat.css
│   └── js/chat.js                 # Socket.IO client logic
```

---

## 4. CodeIgniter 3 Backend (REST API)

### Controller: `Api_Chat.php`
*Handles HTTP requests from the frontend.*

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_Chat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Chat_model');
        // TODO: Validate user session / Bearer JWT here
    }

    // Generate JWT Token for Socket.IO
    public function get_token() {
        $user_id = $this->session->userdata('user_id'); // Or from your auth system
        $payload = [
            'user_id' => $user_id,
            'exp' => time() + (60 * 60 * 24) // 1 day
        ];
        // Use Firebase\JWT to encode
        // $token = JWT::encode($payload, 'YOUR_SHARED_SECRET', 'HS256');
        echo json_encode(['token' => $token]);
    }

    // Send a message
    public function send_message() {
        $sender_id = $this->session->userdata('user_id');
        $receiver_id = $this->input->post('receiver_id');
        $property_id = $this->input->post('property_id');
        $message_text = $this->input->post('message');

        // 1. Get or Create Conversation
        $conv_id = $this->Chat_model->get_or_create_conversation($property_id, $sender_id, $receiver_id);
        
        // 2. Save Message
        $msg_id = $this->Chat_model->save_message($conv_id, $sender_id, $message_text);
        
        // 3. Notify Node.js Server (Server-to-Server request)
        $this->_notify_node_server('new_message', [
            'message_id' => $msg_id,
            'conversation_id' => $conv_id,
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $message_text,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        echo json_encode(['status' => 'success', 'message_id' => $msg_id]);
    }

    // Update Message Status (Read Receipts)
    public function mark_read() {
        $conversation_id = $this->input->post('conversation_id');
        $user_id = $this->session->userdata('user_id');
        
        $this->Chat_model->mark_messages_read($conversation_id, $user_id);
        
        // Notify sender via Node.js
        $this->_notify_node_server('messages_read', [
            'conversation_id' => $conversation_id,
            'reader_id' => $user_id
        ]);
    }

    // Helper to send HTTP POST to Node.js server
    private function _notify_node_server($event, $data) {
        $url = 'http://localhost:3000/internal-api/emit';
        $payload = json_encode(['event' => $event, 'data' => $data]);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'x-internal-secret: YOUR_INTERNAL_SECRET']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1); // 1 sec timeout (fire and forget)
        curl_exec($ch);
        curl_close($ch);
    }
}
```

---

## 5. Node.js + Socket.IO Server

`package.json`:
```json
{
  "name": "chat-server",
  "dependencies": {
    "cors": "^2.8.5",
    "dotenv": "^16.3.1",
    "express": "^4.18.2",
    "jsonwebtoken": "^9.0.1",
    "socket.io": "^4.7.1"
  }
}
```

`server.js`:
```javascript
require('dotenv').config();
const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const jwt = require('jsonwebtoken');

const app = express();
app.use(express.json());

const server = http.createServer(app);
const io = new Server(server, {
    cors: { origin: process.env.ALLOWED_ORIGIN || "*", methods: ["GET", "POST"] }
});

// Middleware for Socket Authentication
io.use((socket, next) => {
    const token = socket.handshake.auth.token;
    if (!token) return next(new Error('Authentication error'));
    
    jwt.verify(token, process.env.JWT_SECRET, (err, decoded) => {
        if (err) return next(new Error('Authentication error'));
        socket.userId = decoded.user_id;
        next();
    });
});

io.on('connection', (socket) => {
    console.log(`User connected: ${socket.userId}`);
    
    // Join a personal room (allows multi-tab support for the same user)
    socket.join(`user_${socket.userId}`);
    
    // Broadcast Online Status
    socket.broadcast.emit('user_status', { user_id: socket.userId, is_online: true });

    // Typing Indicators (Direct Socket-to-Socket)
    socket.on('typing', (data) => {
        socket.to(`user_${data.receiver_id}`).emit('typing', { 
            conversation_id: data.conversation_id, 
            user_id: socket.userId 
        });
    });

    socket.on('disconnect', () => {
        console.log(`User disconnected: ${socket.userId}`);
        socket.broadcast.emit('user_status', { user_id: socket.userId, is_online: false, last_seen: new Date() });
    });
});

// Internal API for CodeIgniter to Trigger Events
app.post('/internal-api/emit', (req, res) => {
    const { event, data } = req.body;
    const internalSecret = req.headers['x-internal-secret'];
    
    if (internalSecret !== process.env.INTERNAL_SECRET) {
        return res.status(403).json({ error: 'Forbidden' });
    }

    if (event === 'new_message') {
        // Send to receiver's room
        io.to(`user_${data.receiver_id}`).emit('new_message', data);
        // Also send back to sender's other tabs
        io.to(`user_${data.sender_id}`).emit('message_sent_success', data);
    } else if (event === 'messages_read') {
        io.to(`user_${data.sender_id}`).emit('messages_read', data);
    }

    res.json({ success: true });
});

server.listen(3000, () => {
    console.log('Socket.IO server running on port 3000');
});
```

---

## 6. Frontend UI (Bootstrap 5) & jQuery Integration

### HTML (chat_ui.php)
```html
<div class="container py-5">
    <div class="row rounded-lg overflow-hidden shadow">
        <!-- Users box-->
        <div class="col-4 px-0">
            <div class="bg-white">
                <div class="messages-box">
                    <div class="list-group rounded-0" id="conversation-list">
                        <!-- Conversation items injected here -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Chat Box-->
        <div class="col-8 px-0">
            <div class="px-4 py-5 chat-box bg-white" id="chat-messages" style="height: 500px; overflow-y: scroll;">
                <!-- Messages injected here -->
            </div>
            <!-- Typing box -->
            <form action="#" class="bg-light" id="chat-form">
                <div class="input-group">
                    <input type="text" id="message-input" placeholder="Type a message" aria-describedby="button-addon2" class="form-control rounded-0 border-0 py-4 bg-light">
                    <div class="input-group-append">
                        <button id="button-addon2" type="submit" class="btn btn-link"> <i class="fa fa-paper-plane"></i></button>
                    </div>
                </div>
            </form>
            <small id="typing-indicator" class="text-muted d-none px-3">User is typing...</small>
        </div>
    </div>
</div>
```

### JS/jQuery (chat.js)
```javascript
const socketToken = 'YOUR_JWT_TOKEN_FROM_CI3';
const activeConversationId = 123;
const currentUserId = 1; 

const socket = io('http://localhost:3000', {
    auth: { token: socketToken },
    reconnection: true
});

socket.on('connect', () => { console.log('Connected to chat server'); });

// Receive Message
socket.on('new_message', (data) => {
    if (data.conversation_id == activeConversationId) {
        appendMessage(data.message, 'left');
        // Auto mark as read via API
        $.post('/api_chat/mark_read', { conversation_id: data.conversation_id });
    } else {
        updateUnreadCount(data.conversation_id);
    }
});

// Typing indicator
let typingTimer;
$('#message-input').on('keyup', () => {
    socket.emit('typing', { receiver_id: 2, conversation_id: activeConversationId });
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => { /* stop typing logic */ }, 1000);
});

socket.on('typing', (data) => {
    if (data.conversation_id == activeConversationId) {
        $('#typing-indicator').removeClass('d-none');
        setTimeout(() => $('#typing-indicator').addClass('d-none'), 2000);
    }
});

// Send Message via CI3 API
$('#chat-form').submit((e) => {
    e.preventDefault();
    const msg = $('#message-input').val();
    if(!msg.trim()) return;
    
    // Append optimistically to UI
    appendMessage(msg, 'right', 'Sending...');
    $('#message-input').val('');

    $.ajax({
        url: '/api_chat/send_message',
        method: 'POST',
        data: {
            receiver_id: 2, // dynamic
            property_id: 10, // dynamic
            message: msg
        },
        success: function(response) {
            // Update UI status to 'Sent'
        }
    });
});
```

---

## 7. Deployment Instructions (Apache/Nginx + PM2)

To run this in production, you must keep the Node.js server running perpetually and expose it securely.

**1. Run Node Server with PM2:**
```bash
npm install -g pm2
cd chat-server
npm install
pm2 start server.js --name "chat-server"
pm2 save
pm2 startup
```

**2. Nginx Reverse Proxy Setup:**
Map your Node.js app (running on `localhost:3000`) to a public URL (e.g., `https://yourdomain.com/socket.io/`).

```nginx
location /socket.io/ {
    proxy_pass http://localhost:3000;
    proxy_http_version 1.1;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection "upgrade";
    proxy_set_header Host $host;
    proxy_cache_bypass $http_upgrade;
}
```

**3. Apache Reverse Proxy Setup:**
If using Apache, enable `mod_proxy` and `mod_proxy_wstunnel`:
```apache
RewriteEngine On
RewriteCond %{REQUEST_URI}  ^/socket.io            [NC]
RewriteCond %{QUERY_STRING} transport=websocket    [NC]
RewriteRule /(.*)           ws://localhost:3000/$1 [P,L]

ProxyPass /socket.io http://localhost:3000/socket.io
ProxyPassReverse /socket.io http://localhost:3000/socket.io
```

---

## 8. Best Practices for Scalability

1. **Redis Integration (Future-Proofing)**:
   When you scale to multiple Node.js instances behind a load balancer, Socket.IO rooms will fail to broadcast across instances. To fix this, use the `@socket.io/redis-adapter`.
2. **Horizontal Scaling**:
   Because Node.js is stateless (auth is in CI3 and rooms are synced via Redis), you can spin up 10 Node.js servers and route traffic using Nginx `ip_hash`.
3. **Database Indexing**:
   Ensure `conversation_id` and `sender_id` are strictly indexed in the MySQL table, as message fetching will be highly active.
4. **Pagination/Infinite Scroll**:
   On the CodeIgniter API side, only load the last 20 messages initially. Load older messages via an Offset/Limit API call when the user scrolls to the top.
