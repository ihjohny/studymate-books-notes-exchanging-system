<?php

include('class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_keyword_list') {

    $object->query = "
    SELECT * FROM user_keyword 
    WHERE userId = ".$_SESSION['user_id']."
    ORDER BY id ASC
    ";
    $data = $object->get_result();

    $isDataFound = false;
    $html = '<div class="container">';

    foreach ($data as $row) {
        $html .= 
            '
                <button id="remove_keyword" style="font-size: 18px; margin: 16px; border-radius: 16px;" type="button" class="btn btn-light" data-id="'.$row["keyword"].'">
                    '.$row['keyword'].'
                    <i style="padding-left: 12px;" class="fas fa-times"></i>
                </button>
            ';

        $isDataFound = true;
    }

    $html .= '</div>';

    if (!$isDataFound) {
        $html =
            '
            <div style="text-align: center;">
                <span">
                    No Keyword Available
                </span>
            </div>
            ';
    }

    echo $html;
}


if ($_POST["action"] == 'remove_keyword') {

    $object->query = "
    DELETE FROM user_keyword 
    WHERE userId = '".$_SESSION['user_id']."' AND keyword = '".$_POST['keyword']."'
    ";

    $object->execute();

    echo '<div class="alert alert-success">'.$_POST['keyword'].' Remove Successful</div>';

}


if ($_POST["action"] == 'add_new_keyword') {

    $object->query = "
       INSERT INTO user_keyword (userId, keyword) VALUES ('".$_SESSION['user_id']."','" . $_POST["keyword"] . "');
    ";

    $object->execute();

    echo '<div class="alert alert-success">'. $_POST["keyword"].' Add Successful</div>';

}

