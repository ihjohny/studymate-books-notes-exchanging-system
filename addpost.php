<div id="addPostModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="post_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Post</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Type<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="post_type" id="post_type" class="form-control" required>
                                    <option value="Request">Request</option>
                                    <option value="Offer">Offer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Title<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="post_title" id="post_title" class="form-control" required data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Category<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="post_category" id="post_category" class="form-control" required>

                                </select>                            
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Writer Name</label>
                            <div class="col-md-9">
                                <input type="text" name="writer_name" id="writer_name" class="form-control" data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Description</label>
                            <div class="col-md-9">
                                <textarea name="description" id="description" class="form-control" data-parsley-trigger="keyup"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Photo</label>
                            <div class="col-md-9">
                                <input type="file" name="post_photo" id="post_photo" />
                                <div id="uploaded_post_photo" class="mt-3"></div>
                                <input type="hidden" name="hidden_post_photo" id="hidden_post_photo" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="" />
                    <input type="submit" name="submit" id="submit_button" class="btn btn-primary" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {

        
        $.ajax({
            url: "addpost_action.php",
            method: "POST",
            data: {
                action: 'fetch_category'
            },
            success: function(data) {
                $('#post_category').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        });

        $('#add_post').click(function() {

            $('#post_form')[0].reset();

            $('#post_form').parsley().reset();

            $('#modal_title').text('Add New Post');

            $('#action').val('add_new_post');

            $('#submit_button').val('Add');

            $('#addPostModal').modal('show');

            $('#form_message').html('');

            $('#post_photo').html('');

            $('#uploaded_post_photo').html('');

            $('#hidden_post_photo').val('');

            $('#hidden_id').val('');

        });

        $('#post_form').parsley();

        $('#post_photo').change(function() {
            var extension = $('#post_photo').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['png', 'jpg']) == -1) {
                    alert("Invalid Image File");
                    $('#post_photo').val('');
                    return false;
                }
            }
        });

        $('#post_form').on('submit', function(event) {

            event.preventDefault();

            if ($('#post_form').parsley().isValid()) {
                $.ajax({
                    url: "addpost_action.php",
                    method: "POST",
                    dataType: 'json',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#submit_button').attr('disabled', 'disabled');
                        $('#submit_button').val('wait...');
                    },
                    success: function(data) {
                        $('#submit_button').attr('disabled', false);
                        $('#submit_button').val('Submit');
                        if (data.error == 'already_accepted') {
                            alert("This post already accepted by user.")
                            $('#form_message').html('This post already accepted by user.');
                        } else {
                            $('#addPostModal').modal('hide');
                            $('#message').html(data.success);
                            dataTable.ajax.reload();

                            setTimeout(function() {
                                $('#message').html('');
                            }, 5000);

                            if(document.getElementById("action").value == "add_new_post") {
                                sendNewPostEmail(data.insert_id);
                            }
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        $('#form_message').html('Something went wrong.');
                        $('#submit_button').attr('disabled', false);
                        $('#submit_button').val('Submit');
                    }
                })
            }
        });

    });

    $(document).on('click', '.edit_button', function() {

        var post_id = $(this).data('id');

        $('#post_form')[0].reset();

        $('#post_form').parsley().reset();

        $('#modal_title').text('Edit Post');

        $('#action').val('edit_post');

        $('#submit_button').val('Edit');

        $('#addPostModal').modal('show');

        $('#form_message').html('');

        $('#hidden_id').val(post_id);

        $.ajax({
            url: "addpost_action.php",
            method: "POST",
            data: {
                post_id: post_id,
                action: 'fetch_single'
            },
            dataType: 'JSON',
            success: function(data) {

                $('#post_title').val(data.title);
                $('#post_type').val(data.type);
                $('#post_category').val(data.tag);
                $('#writer_name').val(data.writerName);
                $('#description').val(data.description);
                $('#uploaded_post_photo').html('<img src="' + data.photo + '" class="img-fluid img-thumbnail" width="100" />')
                $('#hidden_post_photo').val(data.photo);

            },
            error: function(error) {
                console.log(error);
            }
        })
    });

    function sendNewPostEmail(postId) {
        $.ajax({
            url: "addpost_action.php",
            method: "POST",
            data: {
                post_id: postId,
                action: 'send_new_post_email'
            },
            success: function(data) {
                console.log("Emailed ", data);
            },
            error: function(error) {
                console.log(error);
            }
        })
    }

</script>
