<?php

include('class/DbData.php');

$object = new DbData;

if(isset($_POST["user_email_address"]))
{
	sleep(1);
	$error = '';
	$url = '';
	$data = array(
		':user_email_address'	=>	$_POST["user_email_address"]
	);

	$object->query = "
		SELECT * FROM users 
		WHERE email = :user_email_address
	";

	$object->execute($data);

	$total_row = $object->row_count();

	if($total_row == 0)
	{
        $error = '<div class="alert alert-danger">Wrong Email Address</div>';
	}
	else
	{
		$result = $object->statement_result();

		foreach($result as $row)
		{
			if($_POST["user_password"] == $row["password"])
			{
				if(!$object->isUserBlocked($row['id'])) {
					$_SESSION['user_id'] = $row['id'];
					$_SESSION['type'] = 'user';
					$url = 'home.php';
				} else {
					$error = '<div class="alert alert-danger">User Blocked By Admin</div>';
				}
			}
			else
			{
				$error = '<div class="alert alert-danger">Wrong Password</div>';
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