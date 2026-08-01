<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Messages</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7fa; }
        .chat-container { height: calc(100vh - 100px); max-height: 800px; margin-top: 50px; }
        .users-box { border-right: 1px solid #e0e0e0; background: #fff; height: 100%; overflow-y: auto; }
        .chat-box { background: #fff; height: calc(100% - 70px); overflow-y: auto; padding: 20px; }
        .chat-input-area { height: 70px; background: #f8f9fa; border-top: 1px solid #e0e0e0; }
        .msg-bubble { max-width: 70%; padding: 10px 15px; border-radius: 15px; margin-bottom: 15px; clear: both; }
        .msg-left { background: #f1f3f5; color: #333; float: left; border-bottom-left-radius: 0; }
        .msg-right { background: #1F509A; color: #fff; float: right; border-bottom-right-radius: 0; }
        .msg-status { font-size: 10px; opacity: 0.7; margin-left: 10px; }
        .convo-item { padding: 15px; border-bottom: 1px solid #eee; cursor: pointer; transition: 0.2s; }
        .convo-item:hover, .convo-item.active { background: #f4f9fd; }
        .unread-badge { width: 20px; height: 20px; border-radius: 50%; background: #dc3545; color: white; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; }
        .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
        .status-online { background-color: #28a745; }
        .status-offline { background-color: #ccc; }
    </style>
</head>
<body>

<div class="container chat-container shadow-sm rounded-4 overflow-hidden bg-white p-0">
    <div class="row g-0 h-100">
        <!-- Conversations List -->
        <div class="col-md-4 users-box">
            <div class="p-3 bg-light border-bottom">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-comments text-primary me-2"></i> Messages</h5>
            </div>
            <div id="conversations-list">
                <!-- Example Conversation Item -->
                <div class="convo-item d-flex align-items-center active" data-conv-id="1" data-receiver-id="2" data-property-id="10">
                    <img src="https://ui-avatars.com/api/?name=John+Doe&background=random" class="rounded-circle me-3" width="50" height="50">
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="mb-0 text-truncate fw-bold">John Doe</h6>
                            <small class="text-muted" style="font-size: 11px;">10:30 AM</small>
                        </div>
                        <p class="mb-0 text-truncate text-muted small">Is this property still available?</p>
                    </div>
                    <div class="ms-2 text-end">
                        <span class="status-dot status-online" id="status-user-2" title="Online"></span>
                        <div class="unread-badge mt-1 d-none" id="unread-conv-1">0</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-md-8 h-100 position-relative">
            <!-- Chat Header -->
            <div class="p-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name=John+Doe&background=random" class="rounded-circle me-3" width="40" height="40">
                    <div>
                        <h6 class="mb-0 fw-bold">John Doe</h6>
                        <small class="text-success fw-semibold" id="chat-header-status">Online</small>
                    </div>
                </div>
                <div>
                    <button class="btn btn-sm btn-light border"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                </div>
            </div>

            <!-- Messages Area -->
            <div class="chat-box" id="chat-messages">
                <div class="text-center text-muted small mb-4">Chat Started - Property ID #10</div>
                
                <div class="msg-bubble msg-left shadow-sm">
                    Hi, I'm interested in the property.
                    <div class="text-end mt-1"><small class="msg-status">10:30 AM</small></div>
                </div>
                
                <!-- Messages will be injected here -->
            </div>

            <!-- Typing Indicator -->
            <div id="typing-indicator" class="position-absolute d-none text-muted small" style="bottom: 75px; left: 20px;">
                <i class="fa-solid fa-pen text-primary"></i> John is typing...
            </div>

            <!-- Input Area -->
            <form id="chat-form" class="chat-input-area p-3 d-flex align-items-center position-absolute bottom-0 w-100">
                <button type="button" class="btn btn-light text-muted me-2 rounded-circle"><i class="fa-solid fa-paperclip"></i></button>
                <input type="text" id="message-input" class="form-control rounded-pill bg-light border-0 px-4" placeholder="Type a message..." autocomplete="off">
                <button type="submit" class="btn btn-primary rounded-circle ms-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Socket.IO Client Script (Make sure to run your node server on port 3000) -->
<script src="http://localhost:3000/socket.io/socket.io.js"></script>
<script>
$(document).ready(function() {
    let socket;
    let currentUserId = null;
    let activeConvId = 1; // Default for demo
    let receiverId = 2;   // Default for demo
    let propertyId = 10;  // Default for demo

    // 1. Fetch JWT Token from CI3 Backend to authenticate with Socket.IO
    $.ajax({
        url: '<?= site_url("Api_Chat/get_token") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if(res.status === 'success') {
                currentUserId = res.user_id;
                initSocket(res.token);
            } else {
                alert('Failed to authenticate chat.');
            }
        },
        error: function() {
            alert('Error fetching chat token. Make sure Api_Chat controller exists and is accessible.');
        }
    });

    function initSocket(token) {
        socket = io('http://localhost:3000', {
            auth: { token: token },
            reconnection: true
        });

        socket.on('connect', () => {
            console.log('Connected to Chat Server');
        });

        // 2. Listen for Incoming Messages
        socket.on('new_message', (data) => {
            if (data.conversation_id == activeConvId) {
                appendMessage(data.message, 'left', formatTime(new Date()));
                scrollToBottom();
                
                // Auto mark as read
                $.post('<?= site_url("Api_Chat/mark_read") ?>', { 
                    conversation_id: data.conversation_id,
                    other_user_id: data.sender_id 
                });
            } else {
                // Update Unread Badge for other conversations
                let badge = $(`#unread-conv-${data.conversation_id}`);
                badge.text(parseInt(badge.text() || 0) + 1).removeClass('d-none');
            }
        });

        // 3. Listen for My Own Messages from other tabs (Success)
        socket.on('message_sent_success', (data) => {
            if (data.conversation_id == activeConvId) {
                // Could update message status from 'Sending...' to 'Sent'
                $('.sending-status').text('Sent').removeClass('sending-status');
            }
        });

        // 4. Online/Offline Status
        socket.on('user_status', (data) => {
            let dot = $(`#status-user-${data.user_id}`);
            if(dot.length) {
                if(data.is_online) {
                    dot.removeClass('status-offline').addClass('status-online');
                    if(data.user_id == receiverId) $('#chat-header-status').text('Online').removeClass('text-muted').addClass('text-success');
                } else {
                    dot.removeClass('status-online').addClass('status-offline');
                    if(data.user_id == receiverId) $('#chat-header-status').text('Offline').removeClass('text-success').addClass('text-muted');
                }
            }
        });

        // 5. Typing Indicator
        socket.on('typing', (data) => {
            if (data.conversation_id == activeConvId) {
                $('#typing-indicator').removeClass('d-none');
                setTimeout(() => $('#typing-indicator').addClass('d-none'), 2000);
            }
        });
    }

    // 6. Send Typing Event
    let typingTimer;
    $('#message-input').on('keyup', function() {
        if(socket && socket.connected) {
            socket.emit('typing', { receiver_id: receiverId, conversation_id: activeConvId });
        }
    });

    // 7. Send Message Form Submit
    $('#chat-form').submit(function(e) {
        e.preventDefault();
        const msg = $('#message-input').val().trim();
        if(!msg) return;

        // Optimistic UI Update
        appendMessage(msg, 'right', 'Sending...', true);
        $('#message-input').val('');
        scrollToBottom();

        // Send via REST API
        $.ajax({
            url: '<?= site_url("Api_Chat/send_message") ?>',
            type: 'POST',
            data: {
                receiver_id: receiverId,
                property_id: propertyId,
                message: msg
            },
            dataType: 'json',
            success: function(res) {
                if(res.status === 'success') {
                    // Message successfully saved to MySQL and broadcasted
                    $('.sending-status').text(formatTime(new Date())).removeClass('sending-status');
                }
            }
        });
    });

    function appendMessage(text, side, timeStr, isSending = false) {
        const statusClass = isSending ? 'sending-status text-warning' : '';
        const html = `
            <div class="msg-bubble msg-${side} shadow-sm">
                ${escapeHtml(text)}
                <div class="text-end mt-1"><small class="msg-status ${statusClass}">${timeStr}</small></div>
            </div>
            <div class="clearfix"></div>
        `;
        $('#chat-messages').append(html);
    }

    function scrollToBottom() {
        const box = $('#chat-messages');
        box.scrollTop(box[0].scrollHeight);
    }

    function formatTime(date) {
        return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    }

    function escapeHtml(unsafe) {
        return unsafe
             .replace(/&/g, "&amp;")
             .replace(/</g, "&lt;")
             .replace(/>/g, "&gt;")
             .replace(/"/g, "&quot;")
             .replace(/'/g, "&#039;");
    }
});
</script>
</body>
</html>
