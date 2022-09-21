<div id="viewPostModel" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form method="post" id="view_post_form">
            <div id="post_details">

            </div>
        </form>
    </div>
</div>

<script>
    $(document).on('click', '#view_button', function() {

        console.log("button clicked");

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
</script>