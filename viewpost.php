<div id="viewPostModel" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form method="post" id="view_post_form">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title text-white" id="modal_title">View Post Details</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="post_details">
                        <div class="d-flex flex-row">
                            <div class="flex-fill mr-2">
                                <div class="d-flex flex-column">
                                    <img src="../img/demo_book.svg" alt="Photo" class="flex-fill rounded" width="160">
                                    <div class="mt-3">
                                        <h5><strong>This is A Sample Book</strong> </h5>
                                        <p class="text-secondary mb-1"><strong>Type: </strong><span class="badge badge-success lead">Offer</span></p>
                                        <p class="text-secondary mb-1"><strong>Tag: </strong>Computer Programming</p>
                                        <p class="text-secondary mb-1"><strong>Writer Name: </strong>Mr. X</p>
                                        <p class="text-secondary mb-1"><strong>Description: </strong>Lorem Ipsum is simply.</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex flex-column">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Profile" class="rounded-circle" width="100">
                                    <div class="mt-3">
                                        <h5><strong>Another User</strong> <span><button class="btn btn-outline-success btn-sm" disabled>Points: 9</button> </span>
                                        </h5>
                                        <p class="text-secondary mb-1"><strong>Email: </strong>sampleuser@nstu.edu.bd</p>
                                        <p class="text-secondary mb-1"><strong>Phone: </strong>017652328722</p>
                                        <p class="text-secondary mb-1"><strong>Department: </strong>EEE</p>
                                        <p class="text-secondary mb-1"><strong>Roll: </strong>ASH23423432</p>
                                        <p class="text-secondary mb-1"><strong>Address: </strong>Sample User Address</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_appointment_id" id="hidden_appointment_id" />
                    <input type="hidden" name="action" value="change_appointment_status" />
                    <input type="submit" name="save_appointment" id="save_appointment" class="btn btn-success" value="Accept" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).on('click', '#view_button', function() {
        console.log("view post button click");
        $('#viewPostModel').modal('show');
    });
</script>