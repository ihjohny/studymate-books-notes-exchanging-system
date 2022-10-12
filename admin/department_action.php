<?php

include('../class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_departments_list') {

    $object->query = "
    SELECT * FROM departments
    ";
    $data = $object->get_result();

    $html = '<ul class="list-group">';

    $isDataFound = false;

    foreach ($data as $row) {
        $isDataFound = true;

        $html .=
            '
            <li class="list-group-item d-flex justify-content-between align-items-center">
                '.$row['name'].'
                <button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-id="'.$row['name'].'">
                    <i class="fas fa-times"> Delete</i>
                </button>
            </li>
            ';
    }

    $html .= '</ul>';

    if (!$isDataFound) {
        $html =
            '
            <div style="text-align: center;">
                <span">
                    No Department Found
                </span>
            </div>
            ';
    }

    echo $html;
}

if ($_POST["action"] == 'delete_department') {

    $object->query = "
    DELETE FROM departments 
    WHERE name = '" . $_POST["name"] . "'
    ";

    $object->execute();

    echo '<div class="alert alert-success">Department Delete Successful</div>';

}

if ($_POST["action"] == 'add_new_department') {

    $object->query = "
       INSERT INTO departments (name) VALUES ('" . $_POST["name"] . "');
    ";

    $object->execute();

    echo '<div class="alert alert-success">Department Add Successful</div>';

}

