<?php

include('class/DbData.php');

$object = new DbData;

if ($object->is_login()) {
	header("location:" . $object->base_url . "home.php");
}

include('header.php');

?>

<div class="container">
	<div class="row" id="input_view">
    	<div class="col ml-5 pt-md-5">
			<h4>How Studymate Works?</h4>
			<ol>
				<li>Create New Account Or Login</li>
				<li>Create New Post For Book Or Accept Post</li>
				<li>Communicate with each other or Chat</li>
				<li>Donate Or Get Requested Book</li>
			</ol>
    	</div>
   		<div class="col">
		   <div class="row">
				<div class="col col-md-9">
					<span id="message"></span>
					<div class="card">
						<div class="card-header">Login</div>
						<div class="card-body">
							<form method="post" id="user_login_form">
								<div class="form-group">
									<label>User Email Address</label>
									<input type="text" name="user_email_address" id="user_email_address" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" />
								</div>
								<div class="form-group">
									<label>Password</label>
									<input type="password" name="user_password" id="user_password" class="form-control" required data-parsley-trigger="keyup" />
								</div>
								<div class="form-group text-center">
									<input type="hidden" name="action" value="user_login" />
									<input type="submit" name="user_login_button" id="user_login_button" class="btn btn-primary" value="Login" />
								</div>

								<div class="form-group text-center">
									<p><a href="register.php">Register</a></p>
								</div>
							</form>
						</div>
					</div>
					<br />
					<br />
				</div>
			</div>
    	</div>
  </div>
</div>

<?php

include('footer.php');

?>

<script>
	$(document).ready(function() {

		<?php
		if (isset($_GET["verification"])) {
		?>
			$('#input_view').html(
				'<div class="alert alert-success mb-4">Registration Successful. Please Check Your Email Inbox for Email Verification Link</div>'
			);
		<?php
		}
		?>

		<?php
		if (isset($_GET["success-verify"])) {
		?>
			$('#message').html(
				'<div class="alert alert-success mb-4">Your Email has been verified, now you can login into system</div>'
			);
		<?php
		}
		?>

		$('#user_login_form').parsley();

		$('#user_login_form').on('submit', function(event) {

			event.preventDefault();

			if ($('#user_login_form').parsley().isValid()) {
				$.ajax({
					url: "login_action.php",
					method: "POST",
					data: $(this).serialize(),
					dataType: 'json',
					beforeSend: function() {
						$('#user_login_button').attr('disabled', 'disabled');
						$('#user_login_button').val('wait...');
					},
					success: function(data) {
						$('#user_login_button').attr('disabled', false);
						if (data.error != '') {
							$('#message').html(data.error);
							$('#user_login_button').val('Login');
						} else {
							window.location.href = data.url;
						}
					},
					error: function(error) {
						$('#message').html("Something went wrong.");
						$('#user_login_button').attr('disabled', false);
						$('#user_login_button').val('Login');
						console.log("error ", error);
					}
				})
			}
		});

	});
</script>
