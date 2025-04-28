<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments - HomeGenie</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navigationbar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .chat-container {
            max-width: 800px;
            margin: 100px auto 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            height: calc(100vh - 140px);
        }

        .chat-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .back-btn {
            color: #666;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .back-btn:hover {
            color: #333;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message {
            max-width: 70%;
            display: flex;
            flex-direction: column;
        }

        .message.sent {
            align-self: flex-end;
        }

        .message.received {
            align-self: flex-start;
        }

        .message-content {
            padding: 12px 16px;
            border-radius: 15px;
            position: relative;
        }

        .sent .message-content {
            background: #007bff;
            color: white;
            border-bottom-right-radius: 5px;
        }

        .received .message-content {
            background: #f1f1f1;
            color: #333;
            border-bottom-left-radius: 5px;
        }

        .message-time {
            font-size: 0.75rem;
            color: #888;
            margin-top: 5px;
            display: block;
        }

        .sent .message-time {
            text-align: right;
        }

        .chat-input-form {
            padding: 20px;
            border-top: 1px solid #eee;
        }

        .input-group {
            display: flex;
            gap: 10px;
        }

        textarea {
            flex: 1;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 20px;
            resize: none;
            height: 45px;
            font-family: inherit;
        }

        .send-btn {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .send-btn:hover {
            background: #0056b3;
        }

        /* Scrollbar styling */
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>

<body>
    <?php require_once APPROOT . '/views/ServiceProvider/navbar_svp.php'; ?>
    <div class="chat-container">
        <div class="chat-header">
            <div class="user-info">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($data['other_user']->profile_image); ?>"
                    alt="Profile Picture" class="profile-pic">
                <h2><?php echo $data['other_user']->first_name . ' ' . $data['other_user']->last_name; ?></h2>
            </div>
            <a href="<?php echo URLROOT; ?>/ServiceProviderController/appointments" class="back-btn"><i
                    class='bx bx-arrow-back'></i> Back to Appointments</a>
        </div>

        <div class="chat-messages" id="chat-messages">
            <?php foreach ($data['chat_history'] as $message): ?>
                <div class="message <?php echo $message->sender_id == $_SESSION['user_id'] ? 'sent' : 'received'; ?>">
                    <div class="message-content">
                        <p><?php echo htmlspecialchars($message->message); ?></p>
                        <span class="message-time"><?php echo date('M j, g:i a', strtotime($message->created_at)); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <form action="<?php echo URLROOT; ?>/SpChatController/sendMessage" method="POST" class="chat-input-form">
            <input type="hidden" name="receiver_id" value="<?php echo $data['other_user']->user_id; ?>">
            <div class="input-group">
                <textarea name="message" placeholder="Type your message..." required></textarea>
                <button type="submit" class="send-btn"><i class='bx bx-send'></i></button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    </script>
</body>

</html>