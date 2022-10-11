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

    $object->query = "
    SELECT * FROM user_category
    WHERE userId = '" . $_SESSION['user_id'] . "'
    ";
    $user_category_data = $object->get_result();
    $user_cate = array();
    foreach ($user_category_data as $cate) {
        array_push($user_cate, $cate['category']);
    }

    $isDataFound = false;
    $html = '<div class="container">
                <div class="row">
                    <div class="col">
            ';

    foreach ($categories_data as $index => $category_row) {
        if ($index == intval($row_count/2)) {
            $html .= '</div>
                        <div class="col">
                    ';
        }

        $check_status = '';
        foreach($user_cate as $user_category) {
            if($user_category == $category_row['name']) {
                $check_status = 'checked';
            }
        }

        $html .= '
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" data-id="' . $category_row["name"] . '" id="switch_'.$category_row["name"].'" '.$check_status.'>
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


if ($_POST["action"] == 'toggle_subscription') {

    $data = array(
        ':userId'            =>    $_SESSION['user_id'],
        ':category'            =>  $_POST['category']
    );

    if ($_POST["isChecked"] == 'true' ) {
        
        $object->query = "
        INSERT INTO user_category 
        (userId, category) 
        VALUES (:userId, :category)
        ";
        
        $object->execute($data);

    } else {

        $object->query = "
        DELETE FROM user_category 
        WHERE userId = '".$_SESSION['user_id']."' AND category = '".$_POST['category']."'
        ";
    
        $object->execute();

    }

    echo "success";

}

