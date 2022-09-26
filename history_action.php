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
        $creater_name = '';
        $bg_color = '';

        $object->query = "
        SELECT * FROM posts
        WHERE id = '" . $conversation_row["postId"] . "'
        ";
        $post_data = $object->get_result();

        foreach ($post_data as $post_row) {
            $post_name = $post_row["title"];
            $post_type = $post_row["type"];
            if ($post_type == "Offer") {
                $bg_color = "success";
            } else {
                $bg_color = "warning";
            }

            $object->query = "
            SELECT * FROM users
            WHERE id = '" . $post_row["userId"] . "'
            ";
            $user_data = $object->get_result();

            foreach ($user_data as $user_row) {
                $creater_name = $user_row["name"];
            }
        }

        $html .=
            '
            <div id="view_accepted" name="view_accepted" class="col-lg-3 mb-3" style="cursor: pointer;" data-id="' . $conversation_row["id"] . '">
                <div class=" card bg-' . $bg_color . ' text-white shadow" id="view_conversation">
                    <div class="card-body">
                        ' . $post_name . '
                        <div class="mt-1 text-white small">' . $post_type . 'ed by ' . $creater_name . '</div>
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
