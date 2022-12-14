<?php

include('class/DbData.php');

$object = new DbData;

include('header.php');

?>

<div class="container">
    <div class="row justify-content-md-center">
        <div class="col col-md-6">
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form method="post" id="user_register_form">
                        <div class="form-group">
                            <label>User Email Address<span class="text-danger">*</span></label>
                            <input type="text" name="user_email_address" id="user_email_address" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" />
                        </div>
                        <div class="form-group">
                            <label>User Password<span class="text-danger">*</span></label>
                            <input type="password" name="user_password" id="user_password" class="form-control" required data-parsley-trigger="keyup" />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>User Name<span class="text-danger">*</span></label>
                                    <input type="text" name="user_name" id="user_name" class="form-control" required data-parsley-trigger="keyup" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>User Phone No.<span class="text-danger">*</span></label>
                                    <input type="text" name="user_phone_no" id="user_phone_no" class="form-control" required data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>User Roll No.<span class="text-danger">*</span></label>
                                    <input type="text" name="user_roll_no" id="user_roll_no" class="form-control" required data-parsley-trigger="keyup" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>User Department<span class="text-danger">*</span></label>
                                    <select name="user_department" id="user_department" class="form-control">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Complete Address<span class="text-danger">*</span></label>
                            <textarea name="user_address" id="user_address" class="form-control" required data-parsley-trigger="keyup"></textarea>
                        </div>
                        <div class="form-group">
                            <label>User Photo</label><br />
                            <input type="file" name="user_photo" id="user_photo" />
                            <span id="uploaded_user_photo"></span>
                        </div>
                        <div class="form-group text-center">
                            <input type="hidden" name="action" value="user_register" />
                            <input type="submit" name="user_register_button" id="user_register_button" class="btn btn-primary" value="Register" />
                        </div>

                        <div class="form-group text-center">
                            <p><a href="/">Login</a></p>
                        </div>
                        <span id="message"></span>
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
        
        $.ajax({
            url: "register_action.php",
            method: "POST",
            data: {
                action: 'fetch_departments'
            },
            success: function(data) {
                $('#user_department').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        });

    });

    $('#user_register_form').parsley();

    $('#user_register_form').on('submit', function(event) {

        event.preventDefault();

        if ($('#user_register_form').parsley().isValid()) {
            $.ajax({
                url: "register_action.php",
                method:"POST",
				data:new FormData(this),
                dataType:'json',
                contentType:false,
                processData:false,
                beforeSend: function() {
                    $('#user_register_button').attr('disabled', 'disabled');
                },
                success: function(data) {
                    $('#user_register_button').attr('disabled', false);
                    $('#user_register_form')[0].reset();
                    if (data.error !== '') {
                        $('#message').html(data.error);
                    } else {
                        window.location.href = data.url;
                    }
                },
                error: function(error) {
                    $('#user_register_button').attr('disabled', false);
                    $('#message').html("something went wrong.");
                    console.log("error", error);
                }
            });
        }

    });

    $('#user_photo').change(function(){
            var extension = $('#user_photo').val().split('.').pop().toLowerCase();
            if(extension != '')
            {
                if(jQuery.inArray(extension, ['png','jpg']) == -1)
                {
                    alert("Invalid Image File");
                    $('#user_photo').val('');
                    return false;
                }
            }
        });

</script>
