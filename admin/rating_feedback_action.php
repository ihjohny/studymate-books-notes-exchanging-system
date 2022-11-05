<?php

include('../class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_rating_list') {

    $object->query = "
    SELECT * FROM rating_feedback ORDER BY createdAt DESC
    ";
    $data = $object->get_result();

    $html = '<ul class="list-group">';

    $isDataFound = false;

    foreach ($data as $row) {
        $isDataFound = true;

        $post_title = '';
        $object->query = "
        SELECT * FROM posts
        WHERE id = '" . $row["postId"] . "'
        ";
        $post_result = $object->get_result();
        foreach($post_result as $post){
            $post_title = $post['title'];
        }

        $ratedBy = '';
        $ratedTo = '';

        $object->query = "
        SELECT * FROM users
        WHERE id = '" . $row["senderId"] . "'
        ";
        $sender_result = $object->get_result();
        foreach($sender_result as $sender){
            $ratedBy = $sender['name'];
        }

        $object->query = "
        SELECT * FROM users
        WHERE id = '" . $row["receiverId"] . "'
        ";
        $receiver_result = $object->get_result();
        foreach($receiver_result as $receiver){
            $ratedTo = $receiver['name'];
        }

        $html .=
            '
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <h5><strong> Post Title: '.$post_title.'</strong></h5>
                    <span><strong> '.$ratedBy.'</strong> ---> <strong> '.$ratedTo.'</strong></span>
                    </br>
                    <span><strong>Rating: </strong> '.$row['rating'].'</span>
                    </br>
                    <span><strong>Feedback: </strong> '.$row['feedback'].'</span>
                    </br>
                    <span>' . date_format(date_create($row["createdAt"]), 'F j, Y, g:i a'). '</span>
                </div>
            </li>
            ';
    }

    $html .= '</ul>';

    if (!$isDataFound) {
        $html =
            '
            <div style="text-align: center;">
                <span">
                    No Rating and Feedback Found
                </span>
            </div>
            ';
    }

    echo $html;
}
