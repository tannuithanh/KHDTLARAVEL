<!DOCTYPE html>
<html>
<head>
    <title>Create New Chat Room</title>
    <!-- thêm link CSS và JS nếu cần -->
</head>
<body>
    <div class="container">
        <h1>Create New Chat Room</h1>
        <form action="{{ route('chat_rooms.store') }}" method="POST">
            @csrf
            <label for="name">Room Name:</label>
            <input type="text" id="name" name="name" required>
            <button type="submit">Create</button>
        </form>
    </div>
</body>
</html>
