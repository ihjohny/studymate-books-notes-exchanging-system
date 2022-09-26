<?php

include('basehome.php');

if (!isset($_GET["id"])) {
    header("location:" . "/index.php");
}

$object->query = "
    SELECT * FROM conversations 
    WHERE id = '" . $_GET["id"] . "'
";
$conversation_result = $object->get_result();
$conversation_row;
$post_row;
foreach ($conversation_result as $c_row) {
    $conversation_row = $c_row;
    $object->query = "
        SELECT * FROM posts 
        WHERE id = '" . $c_row["postId"] . "'
    ";
    $post_result = $object->get_result();
    foreach ($post_result as $p_row) {
        $post_row = $p_row;
    }
}

?>

<!-- Page Heading -->

<div class="row mb-3">
    <div class="col-sm-8">
        <h1 class="h3 text-gray-800"><?php echo $post_row["title"]; ?></h1>
    </div>
    <div align="center" class="col-sm-4">
        <?php
        if (
            (($post_row["type"] == "Request") and ($conversation_row["posterUserId"] == $_SESSION['user_id']))
            or
            (($post_row["type"] == "Offer") and ($conversation_row["accepterUserId"] == $_SESSION['user_id']))
        ) {
            echo
            '
                <input type="submit" name="received" id="received" class="btn btn-success mr-2" value="Received" />
                <input type="submit" name="discard" id="discard" class="btn btn-warning ml-2" value="Discard" />
            ';
        } else {
            echo
            '
                <div class="alert alert-success">You will get 1 Point</div>
            ';
        }
        ?>
        <div id="message" align="center"></div>
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

<script>
    $(document).on('click', '#received', function() {
        $.ajax({
            url: "conversation_action.php",
            method: "POST",
            data: {
                conversation_id: <?php echo $_GET["id"]; ?>,
                action: 'received'
            },
            beforeSend: function() {
                $('#received').attr('disabled', 'disabled');
                $('#received').val('wait...');
            },
            success: function(data) {
                const result = JSON.parse(data);
                console.log(data);
                $('#received').attr('disabled', false);
                $('#received').val('Received');
                if (!result.error) {
                    window.location.replace("/");
                }
                $('#message').html(result.msg);
                setTimeout(function() {
                    $('#message').html('');
                }, 5000);
            },
            error: function(error) {
                console.log(error);
                $('#received').attr('disabled', false);
                $('#received').val('Received');
            }
        })

    });

    $(document).on('click', '#discard', function() {
        $.ajax({
            url: "conversation_action.php",
            method: "POST",
            data: {
                conversation_id: <?php echo $_GET["id"]; ?>,
                action: 'discard'
            },
            beforeSend: function() {
                $('#discard').attr('disabled', 'disabled');
                $('#discard').val('wait...');
            },
            success: function(data) {
                $('#discard').attr('disabled', false);
                $('#discard').val('Discard');
                $('#message').html(data);
                setTimeout(function() {
                    $('#message').html('');
                }, 5000);

                window.location.replace("/");
            },
            error: function(error) {
                console.log(error);
                $('#discard').attr('disabled', false);
                $('#discard').val('Discard');
            }
        })

    });
</script>