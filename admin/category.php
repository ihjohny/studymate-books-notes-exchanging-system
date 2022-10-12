<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Category</h1>

<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-info">Categories List</h6>
            </div>
            <div class="col" align="right">
                <button type="button" name="add_category" id="add_category" class="btn btn-info btn-sm"><i class="fas fa-plus"> Add New Category</i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="categories_list">

        </div>
    </div>
</div>

<?php
include('footer.php');
?>

<div class="modal fade" id="add_category_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <form method="post" id="category_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <span id="form_message"></span>
                    <div class="form-group">
                        <div class="col">
                            <label class="col">Category Name<span class="text-danger">*</span></label>
                            <div class="col">
                                <input type="text" name="name" id="name" class="form-control" required autofocus data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                </form>
                
                </div>

                <div class="modal-footer">
                        <input type="hidden" name="action" id="action" value="add_new_category" />
                        <input type="submit" name="submit" id="submit_button" class="btn btn-info" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
	</div>
</div>

<script>
    $(document).ready(function() {
        loadCategoryList();

        $('#category_form').on('submit', function(event) {

            event.preventDefault();

            if ($('#category_form').parsley().isValid()) {
                $.ajax({
                    url: "category_action.php",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#submit_button').attr('disabled', 'disabled');
                        $('#submit_button').val('wait...');
                    },
                    success: function(data) {
                        $('#submit_button').attr('disabled', false);
                        $('#submit_button').val('Add');
                        $('#add_category_modal').modal('hide');
                        loadCategoryList();
                    },
                    error: function(error) {
                        console.log(error);
                        $('#form_message').html('Something went wrong.');
                        $('#submit_button').attr('disabled', false);
                        $('#submit_button').val('Add');
                    }
                })
            }
    });
    
    });

    $(document).on('click', '.delete_button', function() {
        const name = $(this).data('id');
        if (confirm("Are you sure you want to delete it?")) {
            $.ajax({
                url: "category_action.php",
                method: "POST",
                data: {
                    name: name,
                    action: 'delete_category'
                },
                success: function(data) {
                    loadCategoryList();
                    $('#message').html(data);
                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            })
        }
    });
    
    function loadCategoryList() {
        $.ajax({
            url: "category_action.php",
            method: "POST",
            data: {
                action: 'fetch_categories_list'
            },
            success: function(data) {
                $('#categories_list').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        })
    };

    $(document).on('click', '#add_category', function() {
        $('#category_form')[0].reset();

        $('#category_form').parsley().reset();
        
        $('#add_category_modal').modal('show');

        $('#form_message').html('');
    });

</script>

