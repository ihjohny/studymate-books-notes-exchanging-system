<?php

include('../class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_all_current_post') {

    $main_query = "
    SELECT * FROM posts WHERE isSuccess = 0
    ";

    $search_query = '';

    if (isset($_POST["search"]["value"])) {
        $search_query .= 'AND(';
        $search_query .= 'title LIKE "%' . $_POST["search"]["value"] . '%" ';
        $search_query .= 'OR category LIKE "%' . $_POST["search"]["value"] . '%" ';
        $search_query .= 'OR writerName LIKE "%' . $_POST["search"]["value"] . '%" ';
        $search_query .= ')';
    }

    $order_query = 'ORDER BY createdAt DESC ';

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

        $sub_array[] = '<button type="button" id="view_button" name="view_button" class="btn btn-info btn-sm" data-id="' . $row["id"] . '"> View </button>';

        $status = '';
        if ($row["isBlock"]) {
            $status = '<button type="button" id="inactive_btn" name="inactive_btn" class="btn btn-danger btn-sm" data-id="' . $row["id"] . '"> Inactive </button>';
        } else {
            $status = '<button type="button" id="active_btn" name="active_btn" class="btn btn-sm btn-success" data-id="' . $row["id"] . '"> Active </button>';
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


if ($_POST["action"] == 'inactive_post') {

    $object->query = "
    UPDATE posts
    SET isBlock = 1
    WHERE id = '" . $_POST['post_id'] . "'
    ";

    $object->execute();

    echo '<div class="alert alert-success">Post Inactive Successful</div>';

}


if ($_POST["action"] == 'active_post') {

    $object->query = "
    UPDATE posts
    SET isBlock = 0
    WHERE id = '" . $_POST['post_id'] . "'
    ";

    $object->execute();

    echo '<div class="alert alert-success">Post Active Successful</div>';

}

