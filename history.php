<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">History</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Previous Accepted Posts</h6>
            </div>
            <div class="col" align="right">

            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="previous_converstation_list">
        </div>
    </div>
</div>

<?php
include('footer.php');
?>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "history_action.php",
            method: "POST",
            data: {
                action: 'fetch_previous_converstation'
            },
            success: function(data) {
                $('#previous_converstation_list').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        })
    });

    $(document).on('click', '#view_accepted', function() {

        window.location = 'conversation.php?id=' + $(this).data('id');

    });
    
</script>