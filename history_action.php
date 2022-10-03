<?php

include('class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_previous_converstation') {

    $object->query = "
    SELECT * FROM conversations
    WHERE ((accepterUserId = '" . $_SESSION['user_id'] . "') OR 
    (posterUserId = '" . $_SESSION['user_id'] . "')) AND (isSuccess = 1)
    ";
    $conversations_data = $object->get_result();

    $html = '<div class="row">';

    $isDataFound = false;
    foreach ($conversations_data as $conversation_row) {
        $isDataFound = true;

        $post_name = '';
        $post_type = '';
        $card_user_id = '';
        $card_user_name = '';
        $card_user_type = '';

        $object->query = "
        SELECT * FROM posts
        WHERE id = '" . $conversation_row["postId"] . "'
        ";
        $post_data = $object->get_result();

        foreach ($post_data as $post_row) {
            $post_name = $post_row["title"];
            $post_type = $post_row["type"];
        }

        if ($conversation_row["posterUserId"] == $_SESSION['user_id']) {
            $card_user_id = $conversation_row["receiverUserId"];
            $card_user_type = "Receiv";
        } else {
            $card_user_id = $conversation_row["posterUserId"];
            $card_user_type = $post_type;
        }

        $object->query = "
        SELECT * FROM users
        WHERE id = '" . $card_user_id . "'
        ";
        $user_data = $object->get_result();

        foreach ($user_data as $user_row) {
            $card_user_name = $user_row["name"];
        }

        $pending_msg = '';

        if (
            $conversation_row["pendingMsgUserId"] != null
            and
            $conversation_row["pendingMsgUserId"] != $_SESSION['user_id']
        ) {
            $pending_msg =
                '
                <span class="position-absolute top-0 start-100 translate-middle badge badge-primary">
                    New Message
                </span>
                ';
        }

        $html .=
            '
            <div id="view_accepted" name="view_accepted" class="col-lg-4 mb-3" style="cursor: pointer;" data-id="' . $conversation_row["id"] . '">
            <div class=" card bg-gradient-primary text-white shadow" id="view_conversation">
                    <div class="row">
                        <div class="col-7">'. $pending_msg .'</div>
                    </div> 
                    <div class="card-body">
                        ' . $post_name . '
                        <div class="mt-1 text-white small">' . $card_user_type . 'ed by ' . $card_user_name . '</div>
                    </div>
                </div>
            </div>
        ';
    }

    $html .= '</div>';

    if (!$isDataFound) {
        $html =
            '
            <div style="text-align: center;">
                <span">
                    No Previous Accepted Post Available
                </span>
            </div>
            ';
    }

    echo $html;
}
