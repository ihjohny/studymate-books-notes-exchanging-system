<?php

include('basehome.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">History</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Previous Accepted Posts</h6>
            </div>
            <div class="col" align="right">

            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="table_status">
            <div class="row">
                <div class="col-lg-3 mb-3" onclick="window.location='conversation.php';" style="cursor: pointer;">
                    <div class=" card bg-warning text-white shadow" id="view_conversation">
                        <div class="card-body">
                            This is a Test Book
                            <div class="mt-1 text-white small">Offered by Another User</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-3" onclick="window.location='conversation.php';" style="cursor: pointer;">
                    <div class=" card bg-success text-white shadow" id="view_conversation">
                        <div class="card-body">
                            This is a Test Book
                            <div class="mt-1 text-white small">Offered by Another User</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-3" onclick="window.location='conversation.php';" style="cursor: pointer;">
                    <div class=" card bg-success text-white shadow" id="view_conversation">
                        <div class="card-body">
                            This is a Test Book
                            <div class="mt-1 text-white small">Offered by Another User</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-3" onclick="window.location='conversation.php';" style="cursor: pointer;">
                    <div class=" card bg-warning text-white shadow" id="view_conversation">
                        <div class="card-body">
                            This is a Test Book
                            <div class="mt-1 text-white small">Offered by Another User</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-3" onclick="window.location='conversation.php';" style="cursor: pointer;">
                    <div class=" card bg-success text-white shadow" id="view_conversation">
                        <div class="card-body">
                            This is a Test Book
                            <div class="mt-1 text-white small">Offered by Another User</div>
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