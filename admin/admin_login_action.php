<?php

include('../class/DbData.php');

$object = new DbData;

if(isset($_POST["admin_email_address"]))
{
	sleep(1);
	$error = '';
	$url = '';
	$data = array(
		':admin_email_address'	=>	$_POST["admin_email_address"]
	);

	$object->query = "
		SELECT * FROM admins 
		WHERE email = :admin_email_address
	";

	$object->execute($data);

	$total_row = $object->row_count();

	if($total_row == 0)
	{
        $error = '<div class="alert alert-danger">Wrong Admin Email Address</div>';
	}
	else
	{
		$result = $object->statement_result();

		foreach($result as $row)
		{
			if($_POST["admin_password"] == $row["password"])
			{
				$_SESSION['admin_id'] = $row['id'];
				$_SESSION['type'] = 'admin';
				$url = 'home.php';
			}
			else
			{
				$error = '<div class="alert alert-danger">Wrong Admin Password</div>';
			}
		}
	}

	$output = array(
		'error'		=>	$error,
		'url'		=>	$url
	);

	echo json_encode($output);
}

?>
