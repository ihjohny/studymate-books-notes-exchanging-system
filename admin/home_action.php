<?php

include('../class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_total_user') {
    
    $object->query = "
    SELECT * FROM users
    ";
    $object->execute();
    echo $object->row_count();

}

if ($_POST["action"] == 'fetch_total_active_post') {
    
    $object->query = "
    SELECT * FROM posts WHERE isSuccess = 0
    ";
    $object->execute();
    echo $object->row_count();
    
}

if ($_POST["action"] == 'fetch_total_successful_request') {
    
    $object->query = "
    SELECT * FROM posts WHERE (isSuccess = 1 AND type = 'request')
    ";
    $object->execute();
    echo $object->row_count();
    
}

if ($_POST["action"] == 'fetch_total_successful_offer') {
    
    $object->query = "
    SELECT * FROM posts WHERE (isSuccess = 1 AND type = 'offer')
    ";
    $object->execute();
    echo $object->row_count();
    
}

