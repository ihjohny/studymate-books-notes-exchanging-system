<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Post</h1>

<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-info">All Current Posts</h6>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="all_current_post_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Action</th>
                        <th>Status</th>
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
    var dataTable;

    $(document).ready(function() {

        dataTable = $('#all_current_post_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "post_action.php",
                type: "POST",
                data: {
                    action: 'fetch_all_current_post'
                }
            },
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4],
                "orderable": false,
            }, ],
        });

    });

    $(document).on('click', '#active_btn', function() {
        const id = $(this).data('id');
        if (confirm("Are you sure you want to inactive it?")) {
            $.ajax({
                url: "post_action.php",
                method: "POST",
                data: {
                    post_id: id,
                    action: 'inactive_post'
                },
                success: function(data) {
                    dataTable.ajax.reload();
                    $('#message').html(data);
                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            });
        }
    });

    $(document).on('click', '#inactive_btn', function() {
        const id = $(this).data('id');
        if (confirm("Are you sure you want to active it?")) {
            $.ajax({
                url: "post_action.php",
                method: "POST",
                data: {
                    post_id: id,
                    action: 'active_post'
                },
                success: function(data) {
                    dataTable.ajax.reload();
                    $('#message').html(data);
                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            });
        }
    });

</script>

<?php
include('viewpost.php');
?>
