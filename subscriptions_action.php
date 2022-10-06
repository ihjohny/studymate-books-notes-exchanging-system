<?php

include('class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_subscriptions') {

    $object->query = "
    SELECT * FROM categories
    ";
    $categories_data = $object->get_result();

    $isDataFound = false;
    $html = '';
    foreach ($categories_data as $category_row) {
        $isDataFound = true;

        $html .=''.$category_row["name"].'';
    }

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
