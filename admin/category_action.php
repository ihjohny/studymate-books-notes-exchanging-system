<?php

include('../class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_categories_list') {

    $object->query = "
    SELECT * FROM categories
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
                    No Category Found
                </span>
            </div>
            ';
    }

    echo $html;
}

if ($_POST["action"] == 'delete_category') {

    $object->query = "
    DELETE FROM categories 
    WHERE name = '" . $_POST["name"] . "'
    ";

    $object->execute();

    echo '<div class="alert alert-success">Category Delete Successful</div>';

}

if ($_POST["action"] == 'add_new_category') {

    $object->query = "
       INSERT INTO categories (name) VALUES ('" . $_POST["name"] . "');
    ";

    $object->execute();

    echo '<div class="alert alert-success">Category Add Successful</div>';

}

