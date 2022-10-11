<?php

include('../class/DbData.php');

$object = new DbData;

if ($object->is_admin_login()) {
	header("location:" . $object->base_url . "home.php");
}

?>

<!doctype html>

<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Studymate Admin</title>

	<!-- Custom styles for this page -->
	<link href="../vendor/bootstrap/bootstrap.min.css" rel="stylesheet">

	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../vendor/parsley/parsley.css" />

	<link rel="stylesheet" type="text/css" href="../vendor/datepicker/bootstrap-datepicker.css" />

	<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<style>
		.border-top {
			border-top: 1px solid #e5e5e5;
		}

		.border-bottom {
			border-bottom: 1px solid #e5e5e5;
		}

		.box-shadow {
			box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05);
		}
	</style>
</head>

<body>
	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
		<div class="col">
			<h5 class="my-0 mr-md-auto font-weight-normal">Studymate</h5>
		</div>
		<?php
		if (!isset($_SESSION['admin_id'])) {
		?>
			<div class="col text-info text-right"><a href="/admin/">Admin Login</a></div>
		<?php
		}
		?>
	</div>

	<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
		<h1 class="display-4">Admin</h1>
	</div>
	<br />
	<br />
	<div class="container-fluid">

<div class="container">
	<div class="row justify-content-md-center">
		<div class="col col-md-4">
			<span id="message"></span>
			<div class="card">
				<div class="card-header">Login</div>
				<div class="card-body">
					<form method="post" id="admin_login_form">
						<div class="form-group">
							<label>Admin Email Address</label>
							<input type="text" name="admin_email_address" id="admin_email_address" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" />
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="admin_password" id="admin_password" class="form-control" required data-parsley-trigger="keyup" />
						</div>
						<div class="form-group text-center">
							<input type="hidden" name="action" value="user_login" />
							<input type="submit" name="admin_login_button" id="admin_login_button" class="btn btn-info" value="Admin Login" />
						</div>
					</form>
				</div>
			</div>
			<br />
			<br />
		</div>
	</div>
</div>

<?php

include('footer.php');

?>

<script>
	$(document).ready(function() {

		$('#admin_login_form').parsley();

		$('#admin_login_form').on('submit', function(event) {

			event.preventDefault();

			if ($('#admin_login_form').parsley().isValid()) {
				$.ajax({
					url: "admin_login_action.php",
					method: "POST",
					data: $(this).serialize(),
					dataType: 'json',
					beforeSend: function() {
						$('#admin_login_button').attr('disabled', 'disabled');
						$('#admin_login_button').val('wait...');
					},
					success: function(data) {
						$('#admin_login_button').attr('disabled', false);
						if (data.error != '') {
							$('#message').html(data.error);
							$('#admin_login_button').val('Admin Login');
						} else {
							window.location.href = data.url;
						}
					},
					error: function(error) {
						$('#message').html("Something went wrong.");
						$('#admin_login_button').attr('disabled', false);
						$('#admin_login_button').val('Admin Login');
						console.log("error ", error);
					}
				})
			}
		});

	});
</script>
