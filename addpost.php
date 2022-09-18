<div id="addPostModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data">
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
                                <select name="user_department" id="user_department" class="form-control">
                                    <option value="offer">Offer</option>
                                    <option value="request">Request</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Title<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="post_title" id="post_title" class="form-control" data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Tag<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="post_tag" id="post_tag" class="form-control" data-parsley-maxlength="25" data-parsley-trigger="keyup" />
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
                                <textarea name="description" id="description" class="form-control" required data-parsley-trigger="keyup"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Photo</label>
                            <div class="col-md-9">
                                <input type="file" name="user_image" id="user_image" />
                                <span id="user_uploaded_image"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
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

            $('#modal_title').text('Add New Post');

            $('#action').val('Add');

            $('#submit_button').val('Add');

            $('#addPostModal').modal('show');

        });

    });
</script>