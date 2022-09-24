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
                            <label class="col-md-3 text-right">Tag<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="post_tag" id="post_tag" class="form-control" data-parsley-maxlength="30" required data-parsley-trigger="keyup" />
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
                                <span id="user_uploaded_image"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" value="add_new_post" />
                    <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#add_post').click(function() {

            $('#post_form')[0].reset();

            $('#post_form').parsley().reset();

            $('#modal_title').text('Add New Post');

            $('#action').val('Add');

            $('#submit_button').val('Add');

            $('#addPostModal').modal('show');

        });

        $('#post_form').parsley();

        $('#post_form').on('submit', function(event) {

            event.preventDefault();

            if ($('#post_form').parsley().isValid()) {
                $.ajax({
                    url: "addpost_action.php",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $('#submit_button').attr('disabled', 'disabled');
                        $('#submit_button').val('wait...');
                    },
                    success: function(data) {
                        $('#submit_button').attr('disabled', false);
                        $('#submit_button').val('Add');
                        if (data.error != '') {
                            $('#form_message').html(data.error);
                        } else {
                            $('#addPostModal').modal('hide');
                            $('#message').html(data.success);
                            dataTable.ajax.reload();

                            setTimeout(function() {
                                $('#message').html('');
                            }, 5000);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        $('#form_message').html('Something went wrong.');
                        $('#submit_button').attr('disabled', false);
                        $('#submit_button').val('Add');
                    }
                })
            }
        });

    });
</script>