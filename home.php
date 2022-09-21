<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Home</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">My Current Accepted Posts</h6>
            </div>
            <div class="col" align="right">

            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="table_status">
            <div class="row">
                <div class="col-lg-3 mb-3" onclick="window.location='conversation.php';" style="cursor: pointer;">
                    <div class=" card bg-success text-white shadow" id="view_conversation">
                        <div class="card-body">
                            This is a Test Book
                            <div class="mt-1 text-white small">Offered by Another User</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-3" onclick="window.location='conversation.php';" style="cursor: pointer;">
                    <div class=" card bg-warning text-white shadow" id="view_conversation">
                        <div class="card-body">
                            This is a Test Book
                            <div class="mt-1 text-white small">Requested by Another User</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">All Posts By Other Users</h6>
            </div>
            <div class="col" align="right">
                <button type="button" name="add_post" id="add_post" class="btn btn-success btn-sm"><i class="fas fa-plus"> Add New Post</i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="all_post_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Title</th>
                        <th>Tag</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                </tbody>

            </table>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>

<script>
    var dateTable;

    $(document).ready(function() {

        dataTable = $('#all_post_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "home_action.php",
                type: "POST",
                data: {
                    action: 'fetch_all'
                }
            },
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4],
                "orderable": false,
            }, ],
        });

    });
</script>

<?php
include('addpost.php');
?>

<?php
include('viewpost.php');
?>