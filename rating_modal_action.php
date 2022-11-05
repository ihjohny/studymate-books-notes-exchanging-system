<?php

include('class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'insert_rating') {

    $object->query = "
    UPDATE users 
    SET rating = ROUND(((rating * rateCount) + '" . $_POST["rating"] . "')/(rateCount+1), 2),
    rateCount = rateCount + 1
    WHERE id = '" . $_POST["user_id"] . "'
    ";
    $object->execute();
    
    $object->query = "
    INSERT INTO `rating_feedback` 
    (`postId`, `senderId`, `receiverId`, `rating`, `feedback`) 
    VALUES ('" .$_POST["post_id"]. "', '" .$_SESSION['user_id']. "', '" .$_POST["user_id"]. "', '" .$_POST["rating"]. "', '" .$_POST["feedback"]. "')
    ";

    $object->execute();

    echo "Rating Insert Success";
}
