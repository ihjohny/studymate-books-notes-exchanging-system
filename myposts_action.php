<?php

include('class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_my_post') {

    $order_column = array('tag', 'type');

    $output = array();

    $main_query = "
    SELECT * FROM posts WHERE userId = '" . $_SESSION['user_id'] . "'
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

        $sub_array[] = '
        <div>
        <button type="button" name="edit_button" class="btn btn-warning btn-sm edit_button" data-id="' . $row["id"] . '"><i class="fas fa-edit"> Edit</i></button>
        &nbsp;
        <button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-id="' . $row["id"] . '"><i class="fas fa-times"> Delete</i></button>
        </div>
        ';

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