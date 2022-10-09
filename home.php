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
        <div id="current_converstation_list">
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
                <button type="button" name="add_post" id="add_post" class="btn btn-primary btn-sm"><i class="fas fa-plus"> Add New Post</i></button>
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
                        <th>Category</th>
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
    $(document).ready(function() {
        $.ajax({
            url: "home_action.php",
            method: "POST",
            data: {
                action: 'fetch_current_converstation',
                user_name: '<?php echo $user_name ?>'
            },
            success: function(data) {
                $('#current_converstation_list').html(data);
            },
            error: function(error) {
                console.log(error);
            }

        })
    });

    $(document).on('click', '#view_accepted', function() {

        window.location = 'conversation.php?id=' + $(this).data('id');

    });

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