<div id="viewPostModel" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div id="post_details">

        </div>
    </div>
</div>

<script>
    $(document).on('click', '#view_button', function() {

        var post_id = $(this).data('id');

        $.ajax({
            url: "viewpost_action.php",
            method: "POST",
            data: {
                post_id: post_id,
                action: 'fetch_single'
            },
            success: function(data) {
                $('#viewPostModel').modal('show');

                $('#post_details').html(data);

                $('#hidden_post_id').val(post_id);
            },
            error: function(error) {
                console.log(error);
            }

        })
    });

    $(document).on('click', '#accept_post', function() {
        var accepted_post_id = $(this).data('id');

        $.ajax({
            url: "viewpost_action.php",
            method: "POST",
            data: {
                accepted_post_id: accepted_post_id,
                action: 'accept_post'
            },
            beforeSend: function() {
                $('#accept_post').attr('disabled', 'disabled');
                $('#accept_post').val('wait...');
            },
            success: function(data) {
                const result = JSON.parse(data);
                if(result.error == "already_received") {
                    alert(result.payload);
                    $('#accept_post').attr('disabled', false);
                    $('#accept_post').val('Accept');
                } else {
                    $('#accept_post').attr('disabled', false);
                    $('#accept_post').val('Accept');
                    $('#viewPostModel').modal('hide');
                    $('#message').html(data.payload);
                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);

                    window.location.replace("/conversation.php?id="+result.conversation_id);

                    sendMail(accepted_post_id, result.conversation_id);
                }
            },
            error: function(error) {
                console.log(error);
                alert(error);
                $('#accept_post').attr('disabled', false);
                $('#accept_post').val('Accept');
            }
        })
    });

    function sendMail(accepted_post_id, conversation_id) {
        $.ajax({
            url: "viewpost_action.php",
            method: "POST",
            data: {
                accepted_post_id: accepted_post_id,
                conversation_id : conversation_id,
                action: 'send_accepted_email'
            },
            success: function(data) {
                console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        })
    }

</script>
