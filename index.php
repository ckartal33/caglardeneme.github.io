<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            background-color: #f0f0f0;
        }
        .chat-container {
            width: 400px;
            height: 590px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }
        .chat-header {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .chat-messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            border-bottom: 1px solid #ddd;
        }
        .chat-messages div {
            margin-bottom: 10px;
        }
        .chat-form {
            display: flex;
            padding: 10px;
        }
        .chat-form input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .chat-form button {
            padding: 10px;
            margin-left: 10px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
           CK ChatBot Uygulaması Deneme V.1.0.1  
        </div>
        <div class="chat-messages" id="chat-messages">
        <form class="chat-form" method="POST" action="send_message.php">
            
            <button type="submit" name="clear_session">Geçmişi Temizle</button>
        </form>
            <?php
                session_start();
                if (!isset($_SESSION['chat_history'])) {
                    $_SESSION['chat_history'] = [];
                }
                foreach ($_SESSION['chat_history'] as $message) {
                    // Eğer giriş hala string ise, onu dizi formatına dönüştür
                    if (is_string($message)) {
                        if (strpos($message, 'You: ') === 0) {
                            $message = [
                                "role" => "USER",
                                "message" => substr($message, 5) // "You: " kısmını çıkar
                            ];
                        } elseif (strpos($message, 'Bot: ') === 0) {
                            $message = [
                                "role" => "CHATBOT",
                                "message" => substr($message, 5) // "Bot: " kısmını çıkar
                            ];
                        }
                    }

                    if ($message['role'] === 'USER') {
                        echo "<div><b>Sen:</b> " . htmlspecialchars($message['message']) . "</div>";
                    } else if ($message['role'] === 'CHATBOT') {
                        echo "<div><b>Bot:</b> " . htmlspecialchars($message['message']) . "</div>";
                    }
                }
            ?>
        </div>
        <form class="chat-form" method="POST" action="send_message.php">
            <input type="text" name="message" placeholder="mesaj..." required>
            <button type="submit">Gönder</button>
          
        </form>

      
    </div>
    <script>
        const chatMessages = document.getElementById('chat-messages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    </script>
</body>
</html>
