<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Subscriptions</h1>
<p>If you subscribe any category you will get email for new post on that category.</p>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Categories</h6>
            </div>
            <div class="col" align="right">

            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="subscriptions_list"></div>
    </div>
</div>

<?php
include('footer.php');
?>

<script>

    $(document).ready(function() {
        $.ajax({
            url: "subscriptions_action.php",
            method: "POST",
            data: {
                action: 'fetch_subscriptions'
            },
            success: function(data) {
                $('#subscriptions_list').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        })
    });
    
</script>
