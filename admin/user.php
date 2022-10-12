<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">User</h1>

<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-info">All Users</h6>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="all_users_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Point</th>
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

        dataTable = $('#all_users_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "user_action.php",
                type: "POST",
                data: {
                    action: 'fetch_all_users'
                }
            },
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4, 5],
                "orderable": false,
            }, ],
        });

    });

    $(document).on('click', '#active_btn', function() {
        const id = $(this).data('id');
        if (confirm("Are you sure you want to block user?")) {
            $.ajax({
                url: "user_action.php",
                method: "POST",
                data: {
                    user_id: id,
                    action: 'inactive_user'
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
        if (confirm("Are you sure you want to unblock user?")) {
            $.ajax({
                url: "user_action.php",
                method: "POST",
                data: {
                    user_id: id,
                    action: 'active_user'
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

