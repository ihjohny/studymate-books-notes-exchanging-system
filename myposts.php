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
                        <td>
                            <div>
                                <button type="button" name="edit_button" class="btn btn-warning btn-sm edit_button" data-id="btn_edit"><i class="fas fa-edit"> Edit</i></button>
                                &nbsp;
                                <button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-id="btn_delete"><i class="fas fa-times"> Delete</i></button>
                            </div>
                        </td>
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
                        <td>
                            <div>
                                <button type="button" name="edit_button" class="btn btn-warning btn-sm edit_button" data-id="btn_edit"><i class="fas fa-edit"> Edit</i></button>
                                &nbsp;
                                <button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-id="btn_delete"><i class="fas fa-times"> Delete</i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>