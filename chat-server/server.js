const express = require('express');
const app = express();
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
  cors: {
    origin: "*",
  }
});

// Danh sách người dùng kết nối
const connectedUsers = {};
function updateUserList() {
  io.emit('user-list', Object.values(connectedUsers));
}
io.on('connection', (socket) => {
  console.log('Có người kết nối: ' + socket.id);
  // Xử lý sự kiện đăng nhập
  socket.on('login', (user) => {
    console.log('Người dùng đăng nhập:', user);
    // Lưu thông tin người dùng kết nối
    connectedUsers[socket.id] = user;
    updateUserList();
  });

  // Xử lý sự kiện gửi tin nhắn
  socket.on('chat-message', (message) => {
    console.log('Tin nhắn từ người dùng:', message);

    // Lấy thông tin người gửi từ connectedUsers
    const user = connectedUsers[socket.id];

    // Gửi tin nhắn tới tất cả người dùng kết nối
    if (user) {
      // Gửi tin nhắn tới tất cả người dùng kết nối
      io.emit('chat-message', { sender: user.name || user.email, message });
    } else {
      console.log('Người dùng không tồn tại:', socket.id);
    }
  });

  // Xử lý sự kiện ngắt kết nối
  socket.on('disconnect', () => {
    console.log('Người dùng ngắt kết nối:', connectedUsers[socket.id].username);
    // Xóa thông tin người dùng khi ngắt kết nối
    delete connectedUsers[socket.id];
    updateUserList();
  });
  
});

server.listen(3000, () => {
  console.log('Máy chủ đang lắng nghe tại cổng 3000');
});
