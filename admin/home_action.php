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
    SELECT * FROM posts WHERE (isSuccess = 1 AND type = 'Request')
    ";
    $object->execute();
    echo $object->row_count();
    
}

if ($_POST["action"] == 'fetch_total_successful_donate') {
    
    $object->query = "
    SELECT * FROM posts WHERE (isSuccess = 1 AND type = 'Donate/Loan')
    ";
    $object->execute();
    echo $object->row_count();
    
}

