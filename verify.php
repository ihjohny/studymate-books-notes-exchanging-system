<?php

include('class/DbData.php');

$object = new DbData;

if ($object->is_login()) {

	header("location:" . $object->base_url . "home.php");

} else {

    if(isset($_GET["code"])){
	    $redirect_url = '';

        $object->query = "
        SELECT * FROM users
        WHERE verificationCode = '".$_GET["code"]."'
        ";

        $object->execute();

        if($object->row_count() > 0) {

            $object->query = "
	        UPDATE users 
	        SET verify = 1 
	        WHERE verificationCode = '".$_GET["code"]."'
	        ";

	        $object->execute();

            $redirect_url = 'location:index.php?success-verify';
        }
        else {

            $redirect_url = 'location:/';
        
        }

        header($redirect_url);
    }
}
?>
