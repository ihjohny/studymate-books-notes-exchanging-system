<?php

include('class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'add_new_post') {

    $error = '';
    $success = '';

    $data = array(
        ':type'            =>    $object->clean_input($_POST["post_type"]),
        ':title'            =>    $object->clean_input($_POST["post_title"]),
        ':tag'            =>    $object->clean_input($_POST["post_tag"]),
        ':writerName'            =>    $object->clean_input($_POST["writer_name"]),
        ':description'            =>    $object->clean_input($_POST["description"]),
        ':photo'            =>    '../img/demo_book.svg',
        ':userId'    =>    $_SESSION['user_id']
    );

    $object->query = "
        INSERT INTO posts 
        (type, title, tag, writerName, description, photo, userId) 
        VALUES (:type, :title, :tag, :writerName, :description, :photo, :userId)
        ";

    $object->execute($data);

    $success = '<div class="alert alert-success">Post Added Successfully</div>';

    $output = array(
        'error'        =>    $error,
        'success'    =>    $success
    );

    echo json_encode($output);
}

if ($_POST["action"] == 'fetch_single') {

    $object->query = "
    SELECT * FROM posts 
    WHERE id = '" . $_POST["post_id"] . "'
    ";

    $post_data = $object->get_result();

    $data = array();

    foreach($post_data as $row) {
        $data['id'] = $row['id'];
        $data['type'] = $row['type'];
        $data['title'] = $row["title"];
        $data['tag'] = $row["tag"];
        $data['writerName'] = $row["writerName"];
        $data['description'] = $row["description"];
        $data['photo'] = $row["photo"];
    }

    echo json_encode($data);

}
