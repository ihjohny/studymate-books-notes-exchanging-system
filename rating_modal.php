<div class="modal fade" id="insertRatingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
    <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Submit Rating and Feedback</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="rating_form_message"></span>
                    <div class="col">
                        <h3 align="center" id="pending_rating_post_title"></h3>
                        <p align="center">Rate User <input type="number" name="inputName" id="user_rating" class="rating"/></p>
                        <label class="col">Feedback (Optional)</span></label>
                        <div class="col">
                            <textarea type="text" name="feedback" id="feedback" class="form-control" autofocus data-parsley-trigger="keyup"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="pending_rating_user_id" id="pending_rating_user_id" />
                    <input type="hidden" name="pending_rating_post_id" id="pending_rating_post_id" />
                    <button id="rating_submit_button" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
	</div>
</div>

<script>
    $(document).ready(function() {

        $(document).on('click', '#rating_submit_button', function() {
            $.ajax({
                    url: "rating_modal_action.php",
                    method: "POST",
                    data: {
                        user_id: $('#pending_rating_user_id').val(),
                        post_id: $('#pending_rating_post_id').val(),
                        rating: $('#user_rating').val(),
                        feedback: feedback.value.trim(),
                        action: 'insert_rating'
                    },
                    beforeSend: function() {
                        $('#rating_submit_button').attr('disabled', 'disabled');
                        $('#rating_submit_button').val('wait...');
                    },
                    success: function(data) {
                        console.log(data);
                        $('#pending_rating_user_id').val('');
                        $('#pending_rating_post_id').val('');
                        $('#pending_rating_post_title').html('');
                        $('#rating_submit_button').attr('disabled', false);
                        $('#rating_submit_button').val('Submit');
                        $('#insertRatingModal').modal('hide');
                    },
                    error: function(error) {
                        console.log(error);
                        $('#rating_form_message').html('Something went wrong.');
                        $('#rating_submit_button').attr('disabled', false);
                        $('#rating_submit_button').val('Submit');
                    }
                })
        });

    });

</script>
