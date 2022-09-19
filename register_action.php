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
            ':password'                =>    $_POST["user_password"]
        );

        $object->query = "
        INSERT INTO `users` 
        (`name`, `email`, `address`, `phone`, `point`, `password`, `department`, `roll`) 
        VALUES ('sample9', :email, 'address', '01763183408', '5', :password, 'ice', 'ash1611008m');
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

?>