<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Offer Posts</h1>

<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Books, Notes Offered by Other Users</h6>
            </div>
            <div class="col" align="right">
                <button type="button" name="add_post" id="add_post" class="btn btn-primary btn-sm"><i class="fas fa-plus"> Add New Post</i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="offer_post_table" width="100%" cellspacing="0">
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
    var dataTable;

    $(document).ready(function() {

        dataTable = $('#offer_post_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "offerposts_action.php",
                type: "POST",
                data: {
                    action: 'fetch_offer'
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