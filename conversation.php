<?php

include('basehome.php');

?>

<!-- Page Heading -->

<div class="row mb-3">
    <div class="col-sm-8">
        <h1 class="h3 text-gray-800">Book Title Here</h1>
    </div>
    <div align="center" class="col-sm-4">
        <input type="submit" name="save_appointment" id="save_appointment" class="btn btn-success mr-2" value="Received" />
        <input type="submit" name="save_appointment" id="save_appointment" class="btn btn-warning ml-2" value="Discard" />
    </div>
</div>

<div class="row">
    <div class="col-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-primary">Conversation</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="flex-grow-0 px-4 msg_history" style="overflow-y: scroll; height:250px;">
                    <div class="incoming_msg">
                        <span><strong>Another User: </strong></span> How are you?
                    </div>
                    <div align="right" class="outgoing_msg">
                        I am fine. Thank You.
                    </div>
                    <div class="incoming_msg">
                        <span><strong>Another User: </strong></span> How are you?
                    </div>
                    <div class="incoming_msg">
                        <span><strong>Another User: </strong></span> How are you?
                    </div>
                    <div class="incoming_msg">
                        <span><strong>Another User: </strong></span> How are you?
                    </div>
                    <div align="right" class="outgoing_msg">
                        I am fine. Thank You.
                    </div>
                    <div align="right" class="outgoing_msg">
                        I am fine. Thank You.
                    </div>
                </div>

                <div class="flex-grow-0 py-3 px-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Type your message">
                        <button class="btn btn-primary ml-2">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col">
                            <h6 class="m-0 font-weight-bold text-primary">Post Details</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <img src="../img/demo_book.svg" alt="Photo" class="flex-fill rounded" width="80">
                        <div class="mt-3">
                            <h5><strong>This is A Sample Book</strong> </h5>
                            <p class="text-secondary mb-1"><strong>Type: </strong><span class="badge badge-success lead">Offer</span></p>
                            <p class="text-secondary mb-1"><strong>Tag: </strong>Computer Programming</p>
                            <p class="text-secondary mb-1"><strong>Writer Name: </strong>Mr. X</p>
                            <p class="text-secondary mb-1"><strong>Description: </strong>Lorem Ipsum is simply.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col">
                            <h6 class="m-0 font-weight-bold text-primary">User Details</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="d-flex flex-column">
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Profile" class="rounded-circle" width="80">
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
    </div>
</div>

<?php
include('footer.php');
?>