<?php

include('basehome.php');

$object->query = "
SELECT * FROM users
WHERE id = '" . $_SESSION["user_id"] . "'
";

$result = $object->get_result();

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Profile</h1>

<!-- DataTales Example -->

<form method="post" id="user_profile_form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-8"><span id="message"></span>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col">
                            <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                        </div>
                        <div clas="col" align="right">
                            <input type="hidden" name="action" value="user_profile" />
                            <button type="submit" name="edit_button" id="edit_button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</button>
                            &nbsp;&nbsp;
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>User Email Address<span class="text-danger">*</span></label>
                        <input type="text" name="user_email_address" id="user_email_address" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" readonly />
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
                                    <option value="ice">ICE</option>
                                    <option value="cste">CSTE</option>
                                    <option value="eee">EEE</option>
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
                        </br>
                        </br>
                        <span id="uploaded_user_photo"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
include('footer.php');
?>

<script>
    $(document).ready(function() {

        <?php
        foreach ($result as $row) {
        ?>
            $('#user_email_address').val("<?php echo $row['email']; ?>");
            $('#user_password').val("<?php echo $row['password']; ?>");
            $('#user_name').val("<?php echo $row['name']; ?>");
            $('#user_phone_no').val("<?php echo $row['phone']; ?>");
            $('#user_roll_no').val("<?php echo $row['roll']; ?>");
            $('#user_department').val("<?php echo $row['department']; ?>");
            $('#user_address').val("<?php echo $row['address']; ?>");

            <?php
            if ($row['photo'] != '') {
            ?>
                $("#uploaded_user_photo").html("<img src='<?php echo $row["photo"]; ?>' class='img-thumbnail' width='100' /><input type='hidden' name='hidden_uploaded_user_photo' value='<?php echo $row['photo']; ?>' />");

            <?php
            } else {
            ?>
                $("#uploaded_user_photo").html("<input type='hidden' name='hidden_uploaded_user_photo' value='' />");
        <?php
            }
        }
        ?>

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

        $('#user_profile_form').parsley();

        $('#user_profile_form').on('submit', function(event) {
            event.preventDefault();

            if ($('#user_profile_form').parsley().isValid()) {
                $.ajax({
                    url: "profile_action.php",
                    method: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#edit_button').attr('disabled', 'disabled');
                        $('#edit_button').html('wait...');
                    },
                    success: function(data) {
                        $('#edit_button').attr('disabled', false);
                        $('#edit_button').html('<i class="fas fa-edit"></i> Edit');

                        if (data.error != '') {
                            $('#message').html(data.error);
                        } else {
                            $('#user_password').val(data.password);
                            $('#user_name').val(data.name);
                            $('#user_phone_no').val(data.phone);
                            $('#user_roll_no').val(data.roll);
                            $('#user_department').val(data.department);
                            $('#user_address').val(data.address);

                            $('#uploaded_user_photo').html('<img src="'+data.photo+'" class="img-thumbnail" width="100" /><input type="hidden" name="hidden_uploaded_user_photo" value="'+data.photo+'" />');

                            $('#message').html(data.success);

                            setTimeout(function() {
                                $('#message').html('');
                                window.location.replace("/profile.php");
                            }, 3000);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        $('#message').html('Something went wrong.');
                        $('#edit_button').attr('disabled', false);
                        $('#edit_button').html('<i class="fas fa-edit"></i> Edit');
                    }
                })
            }
        });

    });
</script>
