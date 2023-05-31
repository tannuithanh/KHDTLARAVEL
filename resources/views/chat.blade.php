<!DOCTYPE html>
<html>
  <head>
    <title>Chat App</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .user-status {
        height: 10px;
        width: 10px;
        background-color: #00ff00;
        border-radius: 50%;
        display: inline-block;
        margin-left: 10px;
        }
    </style>
  </head>
  <body>
    <div class="container py-5">
      <div class="row">
        <div class="col-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Online Users</h5>
              <ul id="user-list" class="list-group list-group-flush"></ul>
            </div>
          </div>
        </div>
        <div class="col-8">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Chat</h5>
              <ul id="message-list" class="list-group list-group-flush mb-3" style="height: 300px; overflow-y: scroll;"></ul>
              <input id="message-input" class="form-control" type="text" placeholder="Nhập tin nhắn" />
              <button id="send-button" class="btn btn-primary mt-2">Gửi</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Socket.IO -->
    <script src="http://10.20.40.169:3000/socket.io/socket.io.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
      var socket = io('http://10.20.40.169:3000');
      var messageList = $('#message-list');
      var userList = $('#user-list');
      var messageInput = $('#message-input');
      var sendButton = $('#send-button');
      var user = @json($user);

      socket.on('connect', function() {
        socket.emit('login', user.name || user.email);
      });

      sendButton.on('click', function() {
        var message = messageInput.val().trim();
        if (message !== '') {
          if (user && user.name) {
            socket.emit('chat-message', { sender: user.name || user.email, message: message });
            messageInput.val('');
          }
        }
      });

      socket.on('chat-message', function(data) {
        var li = $('<li class="list-group-item"></li>');
        li.text(data.message.sender + ': ' + data.message.message);
        messageList.append(li);
        messageList.scrollTop(messageList[0].scrollHeight);
      });

      socket.on('user-list', function(users) {
        userList.empty();
        users.forEach(function(user) {
            var li = $('<li class="list-group-item d-flex justify-content-between align-items-center"></li>'); // Sử dụng d-flex, justify-content-between, và align-items-center
            li.append('<span class="user-name">' + (user) + '</span>'); // Tạo một phần tử span cho tên người dùng
            li.append('<span class="user-status"></span>'); // Tạo một phần tử span cho trạng thái online
            userList.append(li);
            });

        });

    </script>
  </body>
</html>
