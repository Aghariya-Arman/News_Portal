@extends('panel.layout.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Chat System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .chat-container {
            display: flex;
            height: 100vh;
            width: 150%;
        }

        .sidebar1 {
            width: 250px;
            background-color: #fff;
            border-right: 1px solid #ddd;
            padding: 10px;
            overflow-y: auto;
        }

        .contact {
            display: flex;
            align-items: center;
            padding: 10px;
            cursor: pointer;
        }

        .contact:hover {
            background-color: #f1f1f1;
        }

        .contact-avatar {
            width: 40px;
            height: 40px;
            background-color: #ccc;
            border-radius: 50%;
            margin-right: 10px;
        }

        .contact-name {
            font-weight: bold;

        }

        .chat-window {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }

        .messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
        }

        .message {
            margin: 10px 0;
            display: flex;
            flex-direction: column;
        }

        .message-content {
            padding: 10px;
            border-radius: 5px;
            max-width: 60%;
        }

        .message.sent .message-content {
            background-color: #dcf8c6;
            align-self: flex-end;
        }

        .message.received .message-content {
            background-color: #e0d1d1;
            align-self: flex-start;
        }

        .message-time {
            font-size: 0.8em;
            color: #999;
            text-align: right;
        }

        .message-input {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .message-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            margin-right: 10px;
        }

        .message-input button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
        }

        .message-input button:hover {
            background-color: #45a049;
        }
    </style>
</head>
@section('content')
    <div class="pagetitle">
        <h1 class="text-center">Chat With-User </h1>
    </div>
    <section class="section ">
        <div class="row justify-content-center container-fluid">
            <div class="col-lg-8  col-md-8 d-flex flex-column align-items-center justify-content-center">
                @include('panel.layout._message')

                <div class="chat-container">
                    <div class="sidebar1">
                        @foreach ($users as $user)
                            <div class="contact">
                                <div class="contact-avatar"></div>
                                <button class="contact-name border-0 form-control"
                                    value="{{ $user->id }}">{{ $user->name }}</button>
                            </div>
                        @endforeach

                        <!-- Add more contacts as needed -->
                    </div>
                    <div class="chat-window">
                        <div class="messages">
                            {{-- <div class="message sent">
                                <div class="message-content-send"></div>
                                <div class="message-time"></div>
                            </div> --}}
                            {{-- <div class="message received">
                                <div class="message-content">hello</div>
                                <div class="message-time"></div>
                            </div> --}}
                            <!-- Add more messages as needed -->
                        </div>
                        <div class="message-input">
                            <input type="text" placeholder="Type a message..." name="message" />
                            <button type="button" class="sendmsg" data-user-id="">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        let selectedUserId = null;
        let lastAdminMessageId = null;

        $('.contact-name').click(function() {
            var id = $(this).val();
            selectedUserId = id;
            lastAdminMessageId = null;
            $('.messages').empty();
            $('.sendmsg').data('user-id', id);
            fetchMessages(id);
        });

        function fetchMessages(userId) {
            $.ajax({
                type: "POST",
                url: "{{ route('Adminsendmessage') }}",
                data: {
                    id: userId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {

                    const newMessages = response.data.allmessage.filter(function(message) {
                        return message.id > lastAdminMessageId;
                    });


                    newMessages.forEach(function(message) {
                        const finalClass = (message.receiver_id == userId) ? 'sent' :
                            'received';
                        $('.messages').append(
                            `<div class="message ${finalClass}">
                        <div class="message-content">${message.message}</div>
                    </div>`
                        );

                        lastAdminMessageId = message.id;
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
        setInterval(function() {
            if (selectedUserId) {
                fetchMessages(selectedUserId);
            }
        }, 1000);

        $('.sendmsg').click(function() {

            var message = $('input[name=message]').val();
            var userId = $(this).data('user-id');

            if (!userId) {
                alert('Please select a user to send the message to.');
                return;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('adminchatsenmsg') }}",
                data: {
                    message: message,
                    user_id: userId,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    // console.log(response);
                    $('input[name="message"]').val(' ');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
