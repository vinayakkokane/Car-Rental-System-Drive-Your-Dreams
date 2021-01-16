<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bot.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
</head>
<body>
    <div class="chat_icon">
        <p>Having any Queries?</p>
        <i class="fa fa-comments" aria-hidden="true" style="color: black;"></i>
        <p>Chat with us!</p>
    </div>
    <div class="chat_box">
        <div class="wrapper">
            <div class="title">Online Chatbot
                <i class="fa fa-window-minimize min" aria-hidden="true"></i>
            </div>
            <div class="form">
                <div class="bot-inbox inbox">
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="msg-header">
                        <p>Welcome to Drive your Dreams!</p>
                    </div>
                </div>
            </div>
            <div class="typing-field">
                <div class="input-data">
                    <input id="data" type="text" placeholder="Type here.." required>
                    <button id="send-btn">Send</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.chat_icon').click(function() {
                $('.chat_box').toggleClass('active');
                $('.chat_icon').hide();
            });
            $('.min').click(function() {
                $('.chat_box').toggleClass('active');
                $('.chat_icon').show();
            });
            $(".btn-minimize").click(function() {
                $(this).toggleClass('btn-plus');
                $(".content").slideToggle();
            });
            $("#send-btn").on("click", function() {
                $value = $("#data").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>' + $value + '</p></div></div>';
                $(".form").append($msg);
                $("#data").val('');
                // ajax code
                $.ajax({
                    url: 'message.php',
                    type: 'POST',
                    data: 'text=' + $value,
                    success: function(result) {
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>' + result + '</p></div></div>';
                        $(".form").append($replay);
                        // when chat goes down the scroll bar automatically comes to the bottom
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
    </script>
</body>
</html>