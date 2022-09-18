<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Home</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Current Accepted Posts</h6>
            </div>
            <div class="col" align="right">

            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="table_status">
            <div class="row">
                <div class="col-lg-3 mb-3">
                    <div class="card bg-success text-white shadow" id="view_conversation">
                        <div class="card-body">
                            This is a Test Book
                            <div class="mt-1 text-white small">Offered by Another User</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-3">
                    <div class="card bg-success text-white shadow" id="view_conversation">
                        <div class="card-body">
                            Another Book
                            <div class="mt-1 text-white small">Offered by Another User</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-3">
                    <div class="card bg-warning text-white shadow" id="view_conversation">
                        <div class="card-body">
                            Sample Book
                            <div class="mt-1 text-white small">Requested by User</div>
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
                <h6 class="m-0 font-weight-bold text-primary">All Posts</h6>
            </div>
            <div class="col" align="right">
                <button type="button" name="add_post" id="add_post" class="btn btn-success btn-sm"><i class="fas fa-plus"> Add New Post</i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="student_table" width="100%" cellspacing="0">
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
                    <tr>
                        <td><img src="../img/demo_book.svg" class="img-thumbnail" width="100" /></td>
                        <td>This is Sample Data</td>
                        <td>Computer Programming</td>
                        <td>
                            <span class="badge badge-success">Offer</span>
                        </td>
                        <td><button type="button" id="view_button" name="view_button" class="btn btn-primary btn-sm status_button" data-id="data_id" data-status="data_status">View</button></td>
                    </tr>
                </tbody>

                <tbody>
                    <tr>
                        <td><img src="../img/demo_book.svg" class="img-thumbnail" width="100" /></td>
                        <td>This is Sample Data 2</td>
                        <td>Software Engineering</td>
                        <td>
                            <span class="badge badge-warning">Request</span>
                        </td>
                        <td><button type="button" id="view_button" name="view_button" class="btn btn-primary btn-sm status_button" data-id="data_id" data-status="data_status">View</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>

<?php
include('addpost.php');
?>

<?php
include('viewpost.php');
?>

<?php
include('conversation.php');
?>