<?php

include('class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'user_profile') {

    sleep(1);
    $error = '';
    $success = '';

    if ($error == '') {
        $data = array(
            ':password'                =>    $_POST["user_password"],
            ':name'        =>    $object->clean_input($_POST["user_name"]),
            ':phone'        =>    $object->clean_input($_POST["user_phone_no"]),
            ':roll'        =>    $object->clean_input($_POST["user_roll_no"]),
            ':department'        =>    $object->clean_input($_POST["user_department"]),
            ':address'        =>    $object->clean_input($_POST["user_address"]),
        );

        $object->query = "
		UPDATE users  
		SET 
		password = :password, 
		name = :name, 
		phone = :phone, 
		roll = :roll,
		department = :department,
        address = :address
		WHERE id = '" . $_SESSION["user_id"] . "'
		";
        $object->execute($data);

        $success = '<div class="alert alert-success">Profile Data Updated</div>';

        $output = array(
            'error'                    =>    $error,
            'success'                =>    $success,
            'password'    =>    $_POST["user_password"],
            'name'        =>    $_POST["user_name"],
            'phone'            =>    $_POST["user_phone_no"],
            'roll'            =>    $_POST["user_roll_no"],
            'department'        =>    $_POST["user_department"],
            'address'    =>    $_POST["user_address"]
        );

        echo json_encode($output);
    } else {
        $output = array(
            'error'                    =>    $error,
            'success'                =>    $success
        );

        echo json_encode($output);
    }
}
