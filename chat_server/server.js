require('dotenv').config();
const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const jwt = require('jsonwebtoken');

const app = express();
app.use(express.json());

const server = http.createServer(app);
const io = new Server(server, {
    cors: { 
        origin: process.env.ALLOWED_ORIGIN || "*", 
        methods: ["GET", "POST"] 
    }
});

// Middleware for Socket Authentication
io.use((socket, next) => {
    const token = socket.handshake.auth.token;
    if (!token) {
        return next(new Error('Authentication error: Token missing'));
    }
    
    jwt.verify(token, process.env.JWT_SECRET || 'FRE_REALESTATE_SECRET_KEY_123', (err, decoded) => {
        if (err) {
            return next(new Error('Authentication error: Invalid token'));
        }
        socket.userId = decoded.user_id;
        next();
    });
});

io.on('connection', (socket) => {
    console.log(`User connected: ${socket.userId} (Socket ID: ${socket.id})`);
    
    // Join a personal room (allows multi-tab support for the same user)
    socket.join(`user_${socket.userId}`);
    
    // Broadcast Online Status to everyone
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
        socket.broadcast.emit('user_status', { 
            user_id: socket.userId, 
            is_online: false, 
            last_seen: new Date() 
        });
    });
});

// Internal API for CodeIgniter to Trigger Events (Server-to-Server)
app.post('/internal-api/emit', (req, res) => {
    const { event, data } = req.body;
    const internalSecret = req.headers['x-internal-secret'];
    
    // Verify it's coming from our CI3 backend
    if (internalSecret !== (process.env.INTERNAL_SECRET || 'FRE_INTERNAL_SECRET_KEY_456')) {
        return res.status(403).json({ error: 'Forbidden' });
    }

    if (event === 'new_message') {
        // Send to receiver's room
        io.to(`user_${data.receiver_id}`).emit('new_message', data);
        // Also send back to sender's other tabs
        io.to(`user_${data.sender_id}`).emit('message_sent_success', data);
    } else if (event === 'messages_read') {
        // Send to the person who sent the messages, letting them know they were read
        io.to(`user_${data.sender_id}`).emit('messages_read', data);
    }

    res.json({ success: true });
});

const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Socket.IO chat server running on port ${PORT}`);
});
