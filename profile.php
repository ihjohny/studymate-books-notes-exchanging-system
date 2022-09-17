<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Profile</h1>

<!-- DataTales Example -->

<form method="post" id="profile_form" enctype="multipart/form-data">
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
                    <form method="post" id="user_register_form">
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
                            <span id="uploaded_user_photo"></span>
                            </br>
                            </br>
                            <div id="uploaded_image"><img src="../img/undraw_profile.svg" class="img-thumbnail" width="100"></div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
include('footer.php');
?>