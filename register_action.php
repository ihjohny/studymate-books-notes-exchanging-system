<?php

include('class/DbData.php');
include('class/SendEmail.php');

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
        $verification_code = md5(uniqid());

        $user_photo = '../img/undraw_profile.svg';
        if($_FILES["user_photo"]["name"] != '')
        {
            $user_photo = upload_image();
        }

        $data = array(
            ':email'        =>    $object->clean_input($_POST["user_email_address"]),
            ':password'                =>    $_POST["user_password"],
            ':name'        =>    $object->clean_input($_POST["user_name"]),
            ':phone'        =>    $object->clean_input($_POST["user_phone_no"]),
            ':roll'        =>    $object->clean_input($_POST["user_roll_no"]),
            ':department'        =>    $object->clean_input($_POST["user_department"]),
            ':address'        =>    $object->clean_input($_POST["user_address"]),
            ':photo'        =>  $user_photo,
            ':verify'        =>  $object->email_verify,
            ':verificationCode'	=>	$verification_code
        );

        $object->query = "
        INSERT INTO `users` 
        (`name`, `email`, `address`, `phone`, `point`, `password`, `department`, `roll`, `photo`, `verify`, `verificationCode`) 
        VALUES (:name, :email, :address, :phone, '2', :password, :department, :roll, :photo, :verify, :verificationCode);
        ";

        $object->execute($data);

        if(!$object->email_verify) {
            $message_body = '
            <p>For verify your email address, <a href="'.$object->base_url.'verify.php?code='.$verification_code.'"><b>Please click on this link</b></a>.</p>
            </br>
            </br>
            </br>
            <p>Sincerely,</p>
            <p>Studymate</p>
            ';
    
            $email = new SendEmail;
    
            $isSuccess = $email->send(
                array(
                    $object->clean_input($_POST["user_email_address"])
                ),
                'Studymate Verification code for Verify Email Address',
                $message_body 
            );
            
            $url = '/?verification';

        } else {

            $url = '/';

        }

    }

    $output = array(
        'error'        =>    $error,
        'url'    =>    $url
    );
    echo json_encode($output);
}


function upload_image()
{
	if(isset($_FILES["user_photo"]))
	{
		$extension = explode('.', $_FILES['user_photo']['name']);
		$new_name = rand() . '.' . $extension[1];
		$destination = './images/' . $new_name;
		move_uploaded_file($_FILES['user_photo']['tmp_name'], $destination);
		return $destination;
	}
}


if ($_POST["action"] == 'fetch_departments') {

    $object->query = "
    SELECT * FROM departments
    ";

    $department_data = $object->get_result();

    $html = '';

    foreach ($department_data as $row) {
        $html .= '<option value="'.$row["name"].'">'.$row["name"].'</option>';
    }

    echo $html;
}
