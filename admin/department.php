<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Departments</h1>

<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-info">Departments List</h6>
            </div>
            <div class="col" align="right">
                <button type="button" name="add_department" id="add_department" class="btn btn-info btn-sm"><i class="fas fa-plus"> Add New Department</i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="departments_list">

        </div>
    </div>
</div>

<?php
include('footer.php');
?>

<div class="modal fade" id="add_department_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <form method="post" id="department_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Department</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <span id="form_message"></span>
                    <div class="form-group">
                        <div class="col">
                            <label class="col">Department Name<span class="text-danger">*</span></label>
                            <div class="col">
                                <input type="text" name="name" id="name" class="form-control" required autofocus data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                </form>
                
                </div>

                <div class="modal-footer">
                        <input type="hidden" name="action" id="action" value="add_new_department" />
                        <input type="submit" name="submit" id="submit_button" class="btn btn-info" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
	</div>
</div>

<script>
    $(document).ready(function() {
        loadDepartmentsList();

        $('#department_form').on('submit', function(event) {
            console.log("add clicked");

            event.preventDefault();

            if ($('#department_form').parsley().isValid()) {
                $.ajax({
                    url: "department_action.php",
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
                        $('#add_department_modal').modal('hide');
                        loadDepartmentsList();
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
                url: "department_action.php",
                method: "POST",
                data: {
                    name: name,
                    action: 'delete_department'
                },
                success: function(data) {
                    loadDepartmentsList();
                    $('#message').html(data);
                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            })
        }
    });
    
    function loadDepartmentsList() {
        $.ajax({
            url: "department_action.php",
            method: "POST",
            data: {
                action: 'fetch_departments_list'
            },
            success: function(data) {
                $('#departments_list').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        })
    };

    $(document).on('click', '#add_department', function() {
        $('#department_form')[0].reset();

        $('#department_form').parsley().reset();
        
        $('#add_department_modal').modal('show');

        $('#form_message').html('');
    });

</script>

