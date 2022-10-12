<?php

include('../class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_all_users') {

    $main_query = "
    SELECT * FROM users
    ";

    $search_query = '';

    if (isset($_POST["search"]["value"])) {
        $search_query .= 'WHERE (';
        $search_query .= 'name LIKE "%' . $_POST["search"]["value"] . '%" ';
        $search_query .= 'OR email LIKE "%' . $_POST["search"]["value"] . '%" ';
        $search_query .= 'OR phone LIKE "%' . $_POST["search"]["value"] . '%" ';
        $search_query .= ')';
    }

    $order_query = 'ORDER BY id DESC ';

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

        $sub_array[] = '<img src="' . $row["photo"] . '" class="img-thumbnail" width="80" />';
        $sub_array[] = $row["name"];
        $sub_array[] = $row["email"];
        $sub_array[] = $row["phone"];
        $sub_array[] = $row["point"];

        $status = '';
        if ($row["isBlock"]) {
            $status = '<button type="button" id="inactive_btn" name="inactive_btn" class="btn btn-sm btn-success" data-id="' . $row["id"] . '"> Unblock </button>';
        } else {
            $status = '<button type="button" id="active_btn" name="active_btn" class="btn btn-danger btn-sm" data-id="' . $row["id"] . '"> Block </button>';
        }
        $sub_array[] = $status;

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


if ($_POST["action"] == 'inactive_user') {

    $object->query = "
    UPDATE users
    SET isBlock = 1
    WHERE id = '" . $_POST['user_id'] . "'
    ";

    $object->execute();

    $object->query = "
    UPDATE posts
    SET userBlock = 1
    WHERE userId = '" . $_POST['user_id'] . "'
    ";

    $object->execute();

    $object->query = "
    UPDATE conversations
    SET userBlock = 1
    WHERE (posterUserId = '" . $_POST['user_id'] . "') OR (accepterUserId = '" . $_POST['user_id'] . "')
    ";

    $object->execute();

    echo '<div class="alert alert-success">User Block Successful</div>';

}


if ($_POST["action"] == 'active_user') {

    $object->query = "
    UPDATE users
    SET isBlock = 0
    WHERE id = '" . $_POST['user_id'] . "'
    ";

    $object->execute();

    $object->query = "
    UPDATE posts
    SET userBlock = 0
    WHERE userId = '" . $_POST['user_id'] . "'
    ";

    $object->execute();

    $object->query = "
    UPDATE conversations
    SET userBlock = 0
    WHERE (posterUserId = '" . $_POST['user_id'] . "') OR (accepterUserId = '" . $_POST['user_id'] . "')
    ";

    $object->execute();

    echo '<div class="alert alert-success">User Unblock Successful</div>';

}

