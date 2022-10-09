<?php

include('class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_subscriptions') {

    $object->query = "
    SELECT * FROM categories
    ";
    $categories_data = $object->get_result();

    $object->query = "
    SELECT * FROM categories
    ";
    $object->execute();
    $row_count = $object->row_count();

    $isDataFound = false;
    $html = '<div class="container">
                <div class="row">
                    <div class="col">
            ';

    foreach ($categories_data as $index => $category_row) {
        if ($index == $row_count/2) {
            $html .= '</div>
                        <div class="col">
                    ';
        }

        $html .= '
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="switch_'.$category_row["name"].'">
                    <label class="custom-control-label" for="switch_'.$category_row["name"].'"><strong>'.$category_row["name"].'</strong></label>
                </div>
                </br>
            ';

        $isDataFound = true;
    }

    $html .= '      </div>
                </div>
            </div>';

    if (!$isDataFound) {
        $html =
            '
            <div style="text-align: center;">
                <span">
                    No Category Available
                </span>
            </div>
            ';
    }

    echo $html;
}
