<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

<div class="row row-cols-5">

    <div class="col mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div align="center" class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total User
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            <span id="total_user"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div align="center" class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Active Post
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            <span id="total_active_post"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div align="center" class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Successful Request
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            <span id="total_successful_request"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div align="center" class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Successful Offer
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            <span id="total_successful_offer"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div style="height: 200px;"></div>

<?php
include('footer.php');
?>

<script>
    $(document).ready(function() {

        $.ajax({
            url: "home_action.php",
            method: "POST",
            data: {
                action: 'fetch_total_user'
            },
            success: function(data) {
                $('#total_user').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        });

        $.ajax({
            url: "home_action.php",
            method: "POST",
            data: {
                action: 'fetch_total_active_post'
            },
            success: function(data) {
                $('#total_active_post').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        });

        $.ajax({
            url: "home_action.php",
            method: "POST",
            data: {
                action: 'fetch_total_successful_request'
            },
            success: function(data) {
                $('#total_successful_request').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        });

        $.ajax({
            url: "home_action.php",
            method: "POST",
            data: {
                action: 'fetch_total_successful_offer'
            },
            success: function(data) {
                $('#total_successful_offer').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        });

    });

</script>

