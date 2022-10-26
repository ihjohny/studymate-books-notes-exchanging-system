<?php

include('basehome.php');

if (!isset($_GET["id"])) {
?>
    <script>
        location.replace("/");
    </script>
<?php
}

$object->query = "
    SELECT * FROM conversations 
    WHERE id = '" . $_GET["id"] . "'
";
$conversation_result = $object->get_result();
$conversation_row;
$post_row;
$user_id;
$user_row;
$isValid = false;
foreach ($conversation_result as $c_row) {
    if (
        ($c_row["posterUserId"] != $_SESSION['user_id'])
        and
        ($c_row["accepterUserId"] != $_SESSION['user_id'])
    ) {
        $isValid = false;
    } else {
        $isValid = true;
    }

    $conversation_row = $c_row;
    $object->query = "
        SELECT * FROM posts 
        WHERE id = '" . $c_row["postId"] . "'
    ";
    $post_result = $object->get_result();
    foreach ($post_result as $p_row) {
        $post_row = $p_row;
    }

    if ($conversation_row["accepterUserId"] == $_SESSION['user_id']) {
        $user_id = $conversation_row["posterUserId"];
    } else if ($conversation_row["posterUserId"] == $_SESSION['user_id']) {
        $user_id = $conversation_row["accepterUserId"];
    }
    $object->query = "
        SELECT * FROM users 
        WHERE id = '" . $user_id . "'
    ";
    $user_result = $object->get_result();
    foreach ($user_result as $u_row) {
        $user_row = $u_row;
    }
}

$post_type_color = '';
if ($post_row["type"] == 'Request') {
    $post_type_color = 'warning';
} else {
    $post_type_color = 'success';
}

if (!$isValid) {
?>
    <script>
        location.replace("/");
    </script>
<?php
}

?>

<!-- Page Heading -->

<div class="row mb-3">
    <div class="col-sm-8">
        <h1 class="h3 text-gray-800"><?php echo $post_row["title"]; ?></h1>
        <span class="ml-1"><strong><?php echo $object->typed($post_row["type"]) ?> by <?php
                                                                        if ($conversation_row["posterUserId"] == $user_row["id"]) {
                                                                            echo $user_row["name"];
                                                                        } else {
                                                                            echo $user_name;
                                                                        }
                                                                        ?></strong> -> <strong>Accepted by <?php
                                                                                                            if ($conversation_row["accepterUserId"] == $user_row["id"]) {
                                                                                                                echo $user_row["name"];
                                                                                                            } else {
                                                                                                                echo $user_name;
                                                                                                            }
                                                                                                            ?></strong>
            <?php
            if ($conversation_row["isSuccess"]) {
            ?>
                -> <strong>Received by <?php
                                        if ($conversation_row["receiverUserId"] == $user_row["id"]) {
                                            echo $user_row["name"];
                                        } else {
                                            echo $user_name;
                                        }
                                        ?></strong>
            <?php
            } ?>

        </span>
    </div>
    <div align="center" class="col-sm-4">
        <?php
        if (!$conversation_row["isSuccess"]) {
            if (
                (($post_row["type"] == "Request") and ($conversation_row["posterUserId"] == $_SESSION['user_id']))
                or
                (($post_row["type"] == "Donate") and ($conversation_row["accepterUserId"] == $_SESSION['user_id']))
            ) {
                echo
                '
                    <input type="submit" name="received" id="received" class="btn btn-success mr-2" value="Received" />
                    <input type="submit" name="discard" id="discard" class="btn btn-warning ml-2" value="Discard" />
                ';
            } else {
                echo
                '
                    <div class="alert alert-success">You will get 1 Point after success</div>
                ';
            }
        }
        ?>
        <div id="message" align="center"></div>
    </div>
</div>

<div class="row">
    <div class="col-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-primary">Conversation</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="message_list" class="flex-grow-0 px-4 msg_history" style="overflow-y: scroll; height:320px;">
                    <div id="rander_messages"></div>
                </div>

                <div class="flex-grow-0 py-3 px-4">
                        <div class="input-group">
                            <input name="type_message" id="type_message" type="text" class="form-control" placeholder="Type your message">
                            <button id="btn_send" class="btn btn-primary ml-2">Send</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col">
                            <h6 class="m-0 font-weight-bold text-primary">Post Details</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <img src="<?php echo $post_row["photo"]; ?>" alt="Photo" class="flex-fill rounded" width="80">
                        <div class="mt-3">
                            <h5><strong><?php echo $post_row["title"]; ?></strong></h5>
                            <p class="text-secondary mb-1"><strong>Type: </strong><span class="badge badge-<?php echo $post_type_color ?> lead"><?php echo $post_row["type"]; ?></span></p>
                            <p class="text-secondary mb-1"><strong>Category: </strong><?php echo $post_row["category"]; ?></p>
                            <p class="text-secondary mb-1"><strong>Writer Name: </strong><?php echo $post_row["writerName"]; ?></p>
                            <p class="text-secondary mb-1"><strong>Description: </strong><?php echo $post_row["description"]; ?></p>
                            <p class="text-secondary mb-1"><strong>Created At: </strong><?php echo date_format(date_create($post_row["createdAt"]), 'F j, Y, g:i a') ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col">
                            <h6 class="m-0 font-weight-bold text-primary">User Details</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="d-flex flex-column">
                            <img src="<?php echo $user_row["photo"]; ?>" alt="Profile" class="rounded-circle" width="80">
                            <div class="mt-3">
                                <span class="text-success">Points: <?php echo $user_row["point"]; ?></span>
                                <div></div>
                                <span data-toggle="tooltip" data-placement="top" title="Successfull donate made by this user"> <i class="fas fa-arrow-circle-up" style="color:#1cc88a"></i> <strong> <?php echo $user_row["giveCount"]; ?> </strong> </span>
                                <span data-toggle="tooltip" data-placement="top" title="Successfull request made by this user"> <i class="fas fa-arrow-circle-down" style="color:#f6c23e"></i> <strong> <?php echo $user_row["takeCount"]; ?> </strong> </span>
                                <h5 class="mt-1"><strong><?php echo $user_row["name"]; ?></strong></h5>
                                <p class="text-secondary mb-1"><strong>Email: </strong><?php echo $user_row["email"]; ?></p>
                                <p class="text-secondary mb-1"><strong>Phone: </strong><?php echo $user_row["phone"]; ?></p>
                                <p class="text-secondary mb-1"><strong>Department: </strong><?php echo $user_row["department"]; ?></p>
                                <p class="text-secondary mb-1"><strong>Roll: </strong><?php echo $user_row["roll"]; ?></p>
                                <p class="text-secondary mb-1"><strong>Address: </strong><?php echo $user_row["address"]; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>

<script>
    var messageData;

    $(document).ready(function() {
        loadMessages();
        setInterval(function() {
            loadMessages();
        }, 1500);
    });

    $(document).on('click', '#btn_send', function() {
        if (type_message.value.trim() != '') {
            $.ajax({
                url: "conversation_action.php",
                method: "POST",
                data: {
                    message: type_message.value.trim(),
                    conversation_id: <?php echo $_GET["id"]; ?>,
                    user_name: '<?php echo $user_name ?>',
                    action: 'send_message'
                },
                beforeSend: function() {
                    $('#btn_send').attr('disabled', 'disabled');
                    $('#btn_send').val('wait...');
                },
                success: function(data) {
                    $('#type_message').val('');
                    $('#btn_send').attr('disabled', false);
                    $('#btn_send').val('Send');
                    loadMessages();
                },
                error: function(error) {
                    console.log(error);
                    $('#btn_send').attr('disabled', false);
                    $('#btn_send').val('Send');
                }
            })
        }
    });

    $(document).on('click', '#received', function() {
        $.ajax({
            url: "conversation_action.php",
            method: "POST",
            data: {
                conversation_id: <?php echo $_GET["id"]; ?>,
                action: 'received'
            },
            beforeSend: function() {
                $('#received').attr('disabled', 'disabled');
                $('#received').val('wait...');
            },
            success: function(data) {
                const result = JSON.parse(data);
                console.log(data);
                $('#received').attr('disabled', false);
                $('#received').val('Received');
                if (!result.error) {
                    window.location.replace("/");

                    sendMail(<?php echo $_GET["id"]; ?>);
                }
                $('#message').html(result.msg);
                setTimeout(function() {
                    $('#message').html('');
                }, 5000);
            },
            error: function(error) {
                console.log(error);
                $('#received').attr('disabled', false);
                $('#received').val('Received');
            }
        })

    });

    $(document).on('click', '#discard', function() {
        $.ajax({
            url: "conversation_action.php",
            method: "POST",
            data: {
                conversation_id: <?php echo $_GET["id"]; ?>,
                action: 'discard'
            },
            beforeSend: function() {
                $('#discard').attr('disabled', 'disabled');
                $('#discard').val('wait...');
            },
            success: function(data) {
                $('#discard').attr('disabled', false);
                $('#discard').val('Discard');
                $('#message').html(data);
                setTimeout(function() {
                    $('#message').html('');
                }, 5000);

                window.location.replace("/");
            },
            error: function(error) {
                console.log(error);
                $('#discard').attr('disabled', false);
                $('#discard').val('Discard');
            }
        })

    });

    function loadMessages() {
        $.ajax({
            url: "conversation_action.php",
            method: "POST",
            data: {
                action: 'get_messages',
                conversation_id: <?php echo $_GET["id"]; ?>
            },
            success: function(data) {
                if (messageData != data) {
                    $('#rander_messages').html(data);
                    var messageList = document.getElementById('message_list');
                    messageList.scrollTop = messageList.scrollHeight;
                    messageData = data;
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function sendMail(conversation_id) {
        $.ajax({
            url: "conversation_action.php",
            method: "POST",
            data: {
                conversation_id : conversation_id,
                action: 'send_received_email'
            },
            success: function(data) {
                console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        })
    }

</script>