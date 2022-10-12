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
            },
            error: function(error) {
                console.log(error);
            }

        })
    });

</script>
