<?php

include('class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_all') {

    $order_column = array('category', 'type');

    $output = array();

    $main_query = "
    SELECT * FROM posts WHERE userId != '" . $_SESSION['user_id'] . "' AND (isSuccess = 0) AND (isBlock = 0) AND (userBlock = 0)
    ";

    $search_query = '';

    if (isset($_POST["search"]["value"])) {
        $search_query .= 'AND(';
        $search_query .= 'title LIKE "%' . $_POST["search"]["value"] . '%" ';
        $search_query .= 'OR category LIKE "%' . $_POST["search"]["value"] . '%" ';
        $search_query .= 'OR writerName LIKE "%' . $_POST["search"]["value"] . '%" ';
        $search_query .= ')';
    }

    if (isset($_POST["order"])) {
        $order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
        $order_query = 'ORDER BY createdAt DESC ';
    }

    $limit_query = '';

    if ($_POST["length"] != -1) {
        $limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $object->query = $main_query . $search_query . $order_query;

    $object->execute();

    $filtered_rows = $object->row_count();

    $object->query .= $limit_query;

    $result = $object->get_result();

    $object->query = $main_query;

    $object->execute();

    $total_rows = $object->row_count();

    $data = array();

    foreach ($result as $row) {
        $sub_array = array();

        $sub_array[] = '<img src="' . $row["photo"] . '" class="img-thumbnail" width="100" />';
        $sub_array[] = $row["title"];
        $sub_array[] = $row["category"];

        $status = '';
        if ($row["type"] == 'Offer') {
            $status = '<span class="badge badge-success">' . $row["type"] . '</span>';
        } else {
            $status = '<span class="badge badge-warning">' . $row["type"] . '</span>';
        }
        $sub_array[] = $status;

        $sub_array[] = '<button type="button" id="view_button" name="view_button" class="btn btn-primary btn-sm" data-id="' . $row["id"] . '"> View </button>';

        $data[] = $sub_array;
    }

    $output = array(
        "draw"                =>     intval($_POST["draw"]),
        "recordsTotal"      =>  $total_rows,
        "recordsFiltered"     =>     $filtered_rows,
        "data"                =>     $data
    );

    echo json_encode($output);
}

if ($_POST["action"] == 'fetch_current_converstation') {

    $object->query = "
    SELECT * FROM conversations
    WHERE ((accepterUserId = '" . $_SESSION['user_id'] . "') OR 
    (posterUserId = '" . $_SESSION['user_id'] . "')) AND (isSuccess = 0) AND (isBlock = 0) AND (userBlock = 0)
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
            $card_user_id = $conversation_row["accepterUserId"];
            $card_user_type = "Accept";
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

        $pending_action = '';

        if (
            (($post_row["type"] == "Request") and ($conversation_row["posterUserId"] == $_SESSION['user_id']))
            or
            (($post_row["type"] == "Offer") and ($conversation_row["accepterUserId"] == $_SESSION['user_id']))
        ) {
            $pending_action =
                '
                <span class="position-absolute top-0 end-100 translate-middle badge badge-danger">
                    Received Pending
                </span>
                ';
        }

        $html .=
            '
            <div id="view_accepted" name="view_accepted" class="col-lg-4 mb-3" style="cursor: pointer;" data-id="' . $conversation_row["id"] . '">
            <div class=" card bg-gradient-primary text-white shadow" id="view_conversation">
                    <div class="row">
                        <div class="col-7">'. $pending_msg .'</div>
                        <div class="col-5">'. $pending_action .'</div>
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
                    No Accepted Post Available
                </span>
            </div>
            ';
    }

    echo $html;
}
