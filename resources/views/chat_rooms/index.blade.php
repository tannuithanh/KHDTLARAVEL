<!DOCTYPE html>
<html>
<head>
    <title>Chat Rooms</title>
    <!-- thêm link CSS và JS nếu cần -->
</head>
<body>
    <div class="container">
        <h1>Chat Rooms</h1>
        <ul>
            @foreach ($chat_rooms as $chat_room)
                <li>
                    
                        {{ $chat_room->name }}
                   
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
