<?php

include('class/DbData.php');

$object = new DbData;

if (isset($_POST["user_email_address"])) {
    sleep(1);

    $error = '';
    $url = '';

    $data = array(
        ':user_email_address'    =>    $_POST["user_email_address"]
    );

    $object->query = "
    SELECT * FROM users 
    WHERE email = :user_email_address
    ";

    $object->execute($data);

    if ($object->row_count() > 0) {
        $error = '<div class="alert alert-danger">Email Address Already Exists</div>';
    } else {
        $data = array(
            ':email'        =>    $object->clean_input($_POST["user_email_address"]),
            ':password'                =>    $_POST["user_password"],
            ':name'        =>    $object->clean_input($_POST["user_name"]),
            ':phone'        =>    $object->clean_input($_POST["user_phone_no"]),
            ':roll'        =>    $object->clean_input($_POST["user_roll_no"]),
            ':department'        =>    $object->clean_input($_POST["user_department"]),
            ':address'        =>    $object->clean_input($_POST["user_address"])
        );

        $object->query = "
        INSERT INTO `users` 
        (`name`, `email`, `address`, `phone`, `point`, `password`, `department`, `roll`) 
        VALUES (:name, :email, :address, :phone, '2', :password, :department, :roll);
        ";

        $object->execute($data);

        $url = '/';
    }

    $output = array(
        'error'        =>    $error,
        'url'    =>    $url
    );
    echo json_encode($output);
}
