<?php

include('../class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'fetch_single') {

    $object->query = "
    SELECT * FROM posts 
    WHERE id = '" . $_POST["post_id"] . "'
    ";

    $post_data = $object->get_result();
    $post_user_id = '';

    $html = '<div class="modal-content">';

    foreach ($post_data as $post_row) {
        $post_user_id = $post_row["userId"];
        $category_color = '';
        if ($post_row["type"] == 'Request') {
            $category_color .= 'warning';
        } else {
            $category_color .= 'success';
        }

        $html .= '<div class="modal-header bg-' . $category_color . '">';
        $html .= '
        <h4 class="modal-title text-white" id="modal_title">' . $post_row["title"] . '</h4>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div id="post_details">
                <div class="d-flex flex-row">
                    <div class="card shadow flex-fill mr-2">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="m-0 font-weight-bold text-primary">Post Details</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column">
                                <img src="' . $post_row["photo"] . '" alt="Photo" class="flex-fill rounded" width="80">
                                <div class="mt-3">
                                <h5><strong>' . $post_row["title"] . '</strong> </h5>
                                <p class="text-secondary mb-1"><strong>Type: </strong><span class="badge badge-' . $category_color . ' lead">' . $post_row["type"] . '</span></p>
                                <p class="text-secondary mb-1"><strong>Category: </strong>' . $post_row["category"] . '</p>
                                <p class="text-secondary mb-1"><strong>Writer Name: </strong>' . $post_row["writerName"] . '</p>
                                <p class="text-secondary mb-1"><strong>Description: </strong>' . $post_row["description"] . '</p>
                                <p class="text-secondary mb-1"><strong>Created At: </strong>' . date_format(date_create($post_row["createdAt"]), 'F j, Y, g:i a'). '</p>
                        </div>
                    </div>
                </div>
            </div>
        ';

        $object->query = "
        SELECT * FROM users 
        WHERE id = '" . $post_row["userId"] . "'
        ";

        $user_data = $object->get_result();
        foreach ($user_data as $user_row) {
            $html .=
                '
            <div class="card shadow mr-2">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold text-primary">User Details</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column mr-2">
                            <img src="' . $user_row["photo"] . '" alt="Profile" class="rounded-circle" width="80">
                            <div class="mt-3">
                                <h5><strong>' . $user_row["name"] . '</strong> <span><button class="btn btn-outline-success btn-sm" disabled>Points: ' . $user_row["point"] . '</button> </span>
                                </h5>
                                <p class="text-secondary mb-1"><strong>Email: </strong>' . $user_row["email"] . '</p>
                                <p class="text-secondary mb-1"><strong>Phone: </strong>' . $user_row["phone"] . '</p>
                                <p class="text-secondary mb-1"><strong>Department: </strong>' . $user_row["department"] . '</p>
                                <p class="text-secondary mb-1"><strong>Roll: </strong>' . $user_row["roll"] . '</p>
                                <p class="text-secondary mb-1"><strong>Address: </strong>' . $user_row["address"] . '</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>

                </div>
            </div>
        </div>
    </div>

    </div>
            ';
        }
    }

    echo $html;
}

