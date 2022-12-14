<?php

include('class/DbData.php');
include('class/SendEmail.php');

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
        if($c_row['isBlock']) {
            $error = true;
        }
        if($c_row['userBlock']) {
            $error = true;
        }
    }

    if(!$error) {
        
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
                SET point = '" . $receiver_new_points . "', takeCount = takeCount + 1 
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
                    SET point = '" . $sender_new_points . "' , giveCount = giveCount + 1
                    WHERE id = '" . $sender_id . "'
                ";
                $object->execute();
            }

            // mark converstation as success
            $object->query =
                "
                UPDATE conversations 
                SET isSuccess = 1, receiverUserId = '" . $_SESSION['user_id'] . "'
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

            // delete related conversations for this post
            $object->query = "
            DELETE FROM conversations 
            WHERE (postId = '" . $conversation["postId"] . "') AND (id != '" . $_POST["conversation_id"] . "')
            ";
        
            $object->execute();

            // create pending rating entry  
            $object->query = "
            UPDATE users 
            SET pendingRatingUserId = '" . $sender_id . "',
            pendingRatingPostId = '".$conversation["postId"]."'
            WHERE id = '" . $_SESSION['user_id'] . "'
            ";
            $object->execute();

            $object->query = "
            UPDATE users 
            SET pendingRatingUserId = '" . $_SESSION['user_id'] . "',
            pendingRatingPostId = '".$conversation["postId"]."'
            WHERE id = '" . $sender_id . "'
            ";
            $object->execute();

        }

        $msg;
        if ($error) {
            $msg = '<div class="alert alert-danger mt-3">No point available</div>';
        } else {
            $msg = '';
        }

    } else {
        $msg = '<div class="alert alert-danger mt-3">Post Blocked By Admin</div>';
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

    $object->query = "
    UPDATE conversations 
    SET pendingMsgUserId = '" . $_SESSION['user_id'] . "'
    WHERE id = '" . $_POST["conversation_id"] . "'
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
    foreach ($msg_result as $msg_row) {
        if ($msg_row["userId"] == $_SESSION['user_id']) {
            // outgoing message
            $data .= '
                    <div align="right" class="outgoing_msg">
                        ' . $msg_row["message"] . '
                        <div style="font-size:10px;">'.date_format(date_create($msg_row["createdAt"]), 'F j, g:i a').'</div>
                    </div>
                    ';
        } else {
            // incoming message
            $data .= '
                    <div class="incoming_msg">
                        <span><strong>' . $msg_row["userName"] . ': </strong></span> ' . $msg_row["message"] . '
                        <div style="font-size:10px;">'.date_format(date_create($msg_row["createdAt"]), 'F j, g:i a').'</div>
                    </div>
                    ';
        }
    }

    if ($data == '') {
        $data = '
                    <div align="center">
                        <h3><strong>No Messages<strong></h3>
                    </div>
                ';
    }

    $object->query = "
    SELECT * FROM `conversations`
    WHERE id = '" . $_POST["conversation_id"] . "'
    ";

    $c_result = $object->get_result();

    foreach ($c_result as $c_row) {

        if ($c_row["pendingMsgUserId"] != $_SESSION['user_id']) {
            $object->query = "
            UPDATE conversations 
            SET pendingMsgUserId = null
            WHERE id = '" . $_POST["conversation_id"] . "'
            ";

            $object->execute();
        }
        
    }

    echo $data;
}


if ($_POST["action"] == 'send_received_email') {

    $receiver_email = '';
    $post_title = '';

    $object->query = "
    SELECT * FROM `conversations`
    WHERE id = '" . $_POST["conversation_id"] . "'
    ";

    $result = $object->get_result();
   
    foreach($result as $row) {
        $object->query = "
        SELECT * FROM `posts` 
        WHERE id = '" . $row["postId"] . "'
        ";
        $post_result = $object->get_result();
        
        $sender_id = '';
        foreach($post_result as $post_row) {
            $post_title = $post_row["title"];
            if($post_row["type"] == "Request") {
                $sender_id = $row["accepterUserId"];
            } else {
                $sender_id = $row["posterUserId"];
            }
        }
        
        $object->query = "
        SELECT * FROM `users` 
        WHERE id = '" . $sender_id . "'
        ";
        $user_result = $object->get_result();
        foreach($user_result as $user_row) {
            $receiver_email = $user_row["email"];
        }
    }

	$message_body = '
    <p>Hi, Congratulations you get point. Your Studymate post has been received by user.</p>
    <strong>'.$post_title.'</strong>
    </br>
    <p><a href="'.$object->base_url.'conversation.php?id='. $_POST["conversation_id"] .'">
    <b>Click here to see details.</b></a></p>
    </br>
    </br>
    </br>
    <p>Sincerely,</p>
    <p>Studymate</p>
    ';

    $email = new SendEmail;

    $isSuccess = $email->send(
        array($receiver_email),
        'Studymate Post has been Received.',
        $message_body 
    );

    $message = '';

	if($isSuccess)
	{
		$message = 'Mail Success';
	}
	else
	{
        $message = 'Mail Unsuccess';
	}

    echo $message;
}
