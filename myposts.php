<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">My Posts</h1>

<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Manage Own Posts</h6>
            </div>
            <div class="col" align="right">
                <button type="button" name="add_post" id="add_post" class="btn btn-success btn-sm"><i class="fas fa-plus"> Add New Post</i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="my_post_table" width="100%" cellspacing="0">
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
        dataTable = $('#my_post_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "myposts_action.php",
                type: "POST",
                data: {
                    action: 'fetch_my_post'
                }
            },
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4],
                "orderable": false,
            }, ],
        });
    });

    $(document).on('click', '.edit_button', function() {
        $('#modal_title').text('Edit Post');
        $('#action').val('Add');
        $('#submit_button').val('Add');
        $('#addPostModal').modal('show');
    });

    $(document).on('click', '.delete_button', function() {
        var id = $(this).data('id');
        if (confirm("Are you sure you want to delete it?")) {
            $.ajax({
                url: "myposts_action.php",
                method: "POST",
                data: {
                    id: id,
                    action: 'delete_post'
                },
                success: function(data) {
                    $('#message').html(data);
                    dataTable.ajax.reload();
                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            })
        }
    });
</script>

<?php
include('addpost.php');
?>