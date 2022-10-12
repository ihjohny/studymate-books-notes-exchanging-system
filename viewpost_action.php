<?php

include('class/DbData.php');
include('class/SendEmail.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_single') {

    $object->query = "
    SELECT * FROM posts 
    WHERE id = '" . $_POST["post_id"] . "'
    ";

    $post_data = $object->get_result();
    $post_user_id = '';

    $html = '<div class="modal-content">';

    foreach ($post_data as $post_row) {
        $post_user_id = $post_row["userId"];
        $category_color = '';
        if ($post_row["type"] == 'Request') {
            $category_color .= 'warning';
        } else {
            $category_color .= 'success';
        }

        $html .= '<div class="modal-header bg-' . $category_color . '">';
        $html .= '
        <h4 class="modal-title text-white" id="modal_title">' . $post_row["title"] . '</h4>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div id="post_details">
                <div class="d-flex flex-row">
                    <div class="card shadow flex-fill mr-2">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="m-0 font-weight-bold text-primary">Post Details</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column">
                                <img src="' . $post_row["photo"] . '" alt="Photo" class="flex-fill rounded" width="80">
                                <div class="mt-3">
                                <h5><strong>' . $post_row["title"] . '</strong> </h5>
                                <p class="text-secondary mb-1"><strong>Type: </strong><span class="badge badge-' . $category_color . ' lead">' . $post_row["type"] . '</span></p>
                                <p class="text-secondary mb-1"><strong>Category: </strong>' . $post_row["category"] . '</p>
                                <p class="text-secondary mb-1"><strong>Writer Name: </strong>' . $post_row["writerName"] . '</p>
                                <p class="text-secondary mb-1"><strong>Description: </strong>' . $post_row["description"] . '</p>
                        </div>
                    </div>
                </div>
            </div>
        ';

        $model_footer = '';
        if($post_user_id != $_SESSION['user_id']) {
            $model_footer = '
                <div class="modal-footer">
                    <input type="submit" name="accept_post" id="accept_post" class="btn btn-' . $category_color . '" data-id="' . $post_row["id"] . '" value="Accept" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            ';
        }

        $object->query = "
        SELECT * FROM users 
        WHERE id = '" . $post_row["userId"] . "'
        ";

        $user_data = $object->get_result();
        foreach ($user_data as $user_row) {
            $html .=
                '
            <div class="card shadow mr-2">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold text-primary">User Details</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column mr-2">
                            <img src="' . $user_row["photo"] . '" alt="Profile" class="rounded-circle" width="80">
                            <div class="mt-3">
                                <h5><strong>' . $user_row["name"] . '</strong> <span><button class="btn btn-outline-success btn-sm" disabled>Points: ' . $user_row["point"] . '</button> </span>
                                </h5>
                                <p class="text-secondary mb-1"><strong>Email: </strong>' . $user_row["email"] . '</p>
                                <p class="text-secondary mb-1"><strong>Phone: </strong>' . $user_row["phone"] . '</p>
                                <p class="text-secondary mb-1"><strong>Department: </strong>' . $user_row["department"] . '</p>
                                <p class="text-secondary mb-1"><strong>Roll: </strong>' . $user_row["roll"] . '</p>
                                <p class="text-secondary mb-1"><strong>Address: </strong>' . $user_row["address"] . '</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>

                </div>
            </div>
        </div>
    </div>
            '.$model_footer.'
    </div>
            ';
        }
    }

    echo $html;
}

if ($_POST["action"] == 'accept_post') {
    $error = '';
    $payload = '';
    $conversation_id = '';

    $object->query = "
    SELECT * FROM conversations 
    WHERE postId = '" . $_POST["accepted_post_id"] . "' AND accepterUserId = '" . $_SESSION['user_id'] . "'
    ";
    $conversation = $object->execute();
    $conversation_rows = $object->row_count();
    
    $object->query = "
    SELECT * FROM posts 
    WHERE id = '" . $_POST["accepted_post_id"] . "' AND isSuccess = 1
    ";
    $isSuccess = $object->execute();
    $isSuccess_rows = $object->row_count();

    if($isSuccess_rows < 1) {
        
        if ($conversation_rows < 1) {
            $poster_id;
            $object->query = "
            SELECT * FROM posts 
            WHERE id = '" . $_POST["accepted_post_id"] . "'
            ";
            $post_data = $object->get_result();
            foreach ($post_data as $post_row) {
                $poster_id = $post_row["userId"];
            }

            $object->query = "
            INSERT INTO `conversations` 
            (`postId`, `accepterUserId`, `posterUserId`) 
            VALUES ('" . $_POST["accepted_post_id"] . "', '" . $_SESSION['user_id'] . "', '$poster_id');
            ";
            $object->execute();

            $error = '';
            $payload = '<div class="alert alert-success">Post Accept Successful</div>';
        } else {
            $error = 'already_accepted';
            $payload = '<div class="alert alert-success">Post Already Accepted</div>';
        }

        $object->query = "
        SELECT * FROM conversations 
        WHERE postId = '" . $_POST["accepted_post_id"] . "' AND accepterUserId = '" . $_SESSION['user_id'] . "'
        ";
        $conversation_data = $object->get_result();
        foreach ($conversation_data as $c_row) {
            $conversation_id = $c_row["id"];
        }

    } else {
        $error = 'already_received';
        $payload = 'This Post Already Received By User.';
    }

    $output = array(
        'error' => $error,
        'payload' => $payload,
        'conversation_id' => $conversation_id,
    );

    echo json_encode($output);
}

if ($_POST["action"] == 'send_accepted_email') {
    
    $post_user_email = '';
    $post_title = '';
    
    $object->query = "
    SELECT * FROM posts 
    WHERE id = '" . $_POST["accepted_post_id"] . "'
    ";
    $post_result = $object->get_result();
    foreach($post_result as $post_row) {
        $post_title = $post_row["title"];

        $object->query = "
        SELECT * FROM users 
        WHERE id = '" . $post_row["userId"] . "'
        ";
        $user_result = $object->get_result();
        foreach($user_result as $user_row) {
            $post_user_email = $user_row["email"];
        }
    }

	$message_body = '
    <p>Hi, Congratulations Your Studymate Post has been accepted by another user.</p>
    <strong>'.$post_title.'</strong>
    </br>
    <p><a href="http://localhost/conversation.php?id='. $_POST["conversation_id"] .'">
    <b>Click here to see details.</b></a></p>
    </br>
    </br>
    </br>
    <p>Sincerely,</p>
    <p>Studymate</p>
    ';

    $email = new SendEmail;

    $isSuccess = $email->send(
        array($post_user_email),
        'Studymate Post has been Accepted.',
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

