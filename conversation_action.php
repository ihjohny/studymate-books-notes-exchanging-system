<?php

include('class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'received') {

    $error = false;

    // converstation data
    $object->query = "
    SELECT * FROM conversations 
    WHERE id = '" . $_POST["conversation_id"] . "'
    ";
    $c_result = $object->get_result();
    $conversation;
    foreach ($c_result as $c_row) {
        $conversation = $c_row;
    }

    $sender_id;
    if ($conversation["accepterUserId"] == $_SESSION['user_id']) {
        $sender_id = $conversation["posterUserId"];
    } else if ($conversation["posterUserId"] == $_SESSION['user_id']) {
        $sender_id = $conversation["accepterUserId"];
    }

    // receiver points update
    $object->query = "
    SELECT * FROM users 
    WHERE id = '" . $_SESSION['user_id'] . "'
    ";
    $receiver = $object->get_result();
    foreach ($receiver as $user_row) {
        if ($user_row["point"] > 0) {
            $receiver_new_points = $user_row["point"] - 1;
            $object->query = "
            UPDATE users 
            SET point = '" . $receiver_new_points . "' 
            WHERE id = '" . $_SESSION['user_id'] . "'
            ";
            $object->execute();
        } else {
            $error = true;
        }
    }

    if (!$error) {
        // sender points update
        $object->query =
            "
            SELECT * FROM users 
            WHERE id = '" . $sender_id . "'
        ";
        $sender = $object->get_result();
        foreach ($sender as $sender_row) {
            $sender_new_points = $sender_row["point"] + 1;
            $object->query =
                "
                UPDATE users 
                SET point = '" . $sender_new_points . "' 
                WHERE id = '" . $sender_id . "'
            ";
            $object->execute();
        }

        // mark converstation as success
        $object->query =
            "
            UPDATE conversations 
            SET isSuccess = 1
            WHERE id = '" . $conversation["id"] . "'
        ";
        $object->execute();

        // mark post as success
        $object->query =
            "
            UPDATE posts 
            SET isSuccess = 1
            WHERE id = '" . $conversation["postId"] . "'
        ";
        $object->execute();
    }

    $msg;
    if ($error) {
        $msg = '<div class="alert alert-danger mt-3">No point available</div>';
    } else {
        $msg = '';
    }

    $output = array(
        'error' => $error,
        'msg' => $msg,
    );

    echo json_encode($output);
}


if ($_POST["action"] == 'discard') {

    $object->query = "
    DELETE FROM conversations 
    WHERE id = '" . $_POST["conversation_id"] . "'
    ";

    $object->execute();

    echo '<div class="alert alert-success">Discard Successful</div>';
}


if ($_POST["action"] == 'send_message') {
    $object->query = "
    INSERT INTO `messages` 
    (`conversationId`, `message`, `userId`, `userName`) 
    VALUES ('" . $_POST["conversation_id"] . "', '" . $_POST["message"] . "', '" . $_SESSION['user_id'] . "', '" . $_POST["user_name"] . "')
    ";

    $object->execute();
}


if ($_POST["action"] == 'get_messages') {
    $object->query = "
    SELECT * FROM `messages`
    WHERE conversationId = '" . $_POST["conversation_id"] . "'
    ";

    $msg_result = $object->get_result();
    $data = '';
    foreach($msg_result as $msg_row) {
        if($msg_row["userId"] == $_SESSION['user_id']) {
            // outgoing message
            $data .= '
                    <div align="right" class="outgoing_msg">
                        '.$msg_row["message"].'
                    </div>
                    ';
        } else {
            // incoming message
            $data .= '
                    <div class="incoming_msg">
                        <span><strong>'.$msg_row["userName"].': </strong></span> '.$msg_row["message"].'
                    </div>
                    ';
        }
    }

    if($data =='') {
        $data = '
                    <div align="center">
                        <span><strong>No Messages<strong></span>
                    </div>
                ';
    }

    echo $data;
}
