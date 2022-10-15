<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Keyword Subscriptions</h1>

<div class="mt-4">
    <p>If you subscribe any keyword you will get email if new post title contain that keyword.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Keywords</h6>
                </div>
                <div class="col" align="right">
                    <button type="button" name="add_keyword" id="add_keyword" class="btn btn-primary btn-sm"><i class="fas fa-plus"> Add New Keyword</i></button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <span id="message"></span>
            <div id="keywords_list"></div>
        </div>
    </div>
</div>


<div class="modal fade" id="add_keyword_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <form method="post" id="keyword_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Keyword</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <span id="form_message"></span>
                    <div class="form-group">
                        <div class="col">
                            <label class="col">Keyword<span class="text-danger">*</span></label>
                            <div class="col">
                                <input type="text" name="keyword" id="keyword" class="form-control" required autofocus data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                </form>
                
                </div>

                <div class="modal-footer">
                        <input type="hidden" name="action" id="action" value="add_new_keyword" />
                        <input type="submit" name="submit" id="submit_button" class="btn btn-primary" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
	</div>
</div>


<?php
include('footer.php');
?>

<script>

    $(document).ready(function() {
        loadKeywordList();
    });

    $(document).on('click', '#add_keyword', function() {
        $('#keyword_form')[0].reset();

        $('#keyword_form').parsley().reset();
        
        $('#add_keyword_modal').modal('show');

        $('#form_message').html('');
    });

    $(document).on('submit', '#keyword_form', function(event) { 
        
        event.preventDefault();
    
        if ($('#keyword_form').parsley().isValid()) {
            console.log("add called", Date());
            $.ajax({
                url: "keyword_subscriptions_action.php",
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
                    $('#add_keyword_modal').modal('hide');
                    loadKeywordList();
                    console.log(data);
                },
                error: function(error) {
                    console.log(error);
                    $('#form_message').html('Something went wrong.');
                    $('#submit_button').attr('disabled', false);
                    $('#submit_button').val('Add');
                }
            });
        }
    });

    $(document).on('click', '#remove_keyword', function() {
        const keyword = $(this).data('id');
        if (confirm(`Are you sure you want to remove ${keyword}?`)) {
            $.ajax({
            url: "keyword_subscriptions_action.php",
            method: "POST",
            data: {
                action: 'remove_keyword',
                keyword: keyword
            },
            success: function(data) {
                console.log(data, ' removed');
                loadKeywordList();
                $('#message').html(data);
                setTimeout(function() {
                    $('#message').html('');
                }, 5000);                
            },
            error: function(error) {
                console.log(error);
            }
        })
        }
    });

    function loadKeywordList() {
        $.ajax({
            url: "keyword_subscriptions_action.php",
            method: "POST",
            data: {
                action: 'fetch_keyword_list'
            },
            success: function(data) {
                $('#keywords_list').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    };

</script>

