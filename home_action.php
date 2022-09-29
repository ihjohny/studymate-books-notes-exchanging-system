<?php

include('class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_all') {

    $order_column = array('tag', 'type');

    $output = array();

    $main_query = "
    SELECT * FROM posts WHERE userId != '" . $_SESSION['user_id'] . "' AND (isSuccess = 0)
    ";

    $search_query = '';

    if (isset($_POST["search"]["value"])) {
        $search_query .= 'AND(';
        $search_query .= 'title LIKE "%' . $_POST["search"]["value"] . '%" ';
        $search_query .= 'OR tag LIKE "%' . $_POST["search"]["value"] . '%" ';
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
        $sub_array[] = $row["tag"];

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
    (posterUserId = '" . $_SESSION['user_id'] . "')) AND (isSuccess = 0)
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
            <div id="view_accepted" name="view_accepted" class="col-lg-4 mb-3" style="cursor: pointer;" data-id="' . $conversation_row["id"] . '">
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
                    No Accepted Post Available
                </span>
            </div>
            ';
    }

    echo $html;
}
