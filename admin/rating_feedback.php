<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Rating and Feedback</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-info">Users Rating and Feedback List</h6>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="rating_list">

        </div>
    </div>
</div>

<?php
include('footer.php');
?>

<script>

    $(document).ready(function() {
        $.ajax({
            url: "rating_feedback_action.php",
            method: "POST",
            data: {
                action: 'fetch_rating_list'
            },
            success: function(data) {
                $('#rating_list').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        })    
    });

</script>
