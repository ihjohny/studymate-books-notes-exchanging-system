<?php

include('class/DbData.php');

$object = new DbData;

if ($_POST["action"] == 'add_new_post') {

    $error = '';
    $success = '';

    $post_photo = '../img/demo_book.svg';
    if($_FILES["post_photo"]["name"] != '')
    {
        $post_photo = upload_image();
    }

    $data = array(
        ':type'            =>    $object->clean_input($_POST["post_type"]),
        ':title'            =>    $object->clean_input($_POST["post_title"]),
        ':tag'            =>    $object->clean_input($_POST["post_category"]),
        ':writerName'            =>    $object->clean_input($_POST["writer_name"]),
        ':description'            =>    $object->clean_input($_POST["description"]),
        ':photo'            =>    $post_photo,
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

    foreach ($post_data as $row) {
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


if ($_POST["action"] == 'fetch_category') {

    $object->query = "
    SELECT * FROM categories
    ";

    $category_data = $object->get_result();

    $html = '';

    foreach ($category_data as $row) {
        $html .= '<option value="'.$row["name"].'">'.$row["name"].'</option>';
    }

    echo $html;
}


if ($_POST["action"] == 'edit_post') {

    $error = '';
    $success = '';
    $isValid = true;

    $object->query = "
    SELECT * FROM conversations 
    WHERE postId = '" . $_POST["hidden_id"] . "'
    ";
    $c_data = $object->get_result();
    foreach($c_data as $c_row) {
        $isValid = false;
    }

    if($isValid) {

        $post_photo = $_POST["hidden_post_photo"];
        if($_FILES["post_photo"]["name"] != '')
        {
            $post_photo = upload_image();
        }

        $data = array(
            ':type'            =>    $object->clean_input($_POST["post_type"]),
            ':title'            =>    $object->clean_input($_POST["post_title"]),
            ':tag'            =>    $object->clean_input($_POST["post_category"]),
            ':writerName'            =>    $object->clean_input($_POST["writer_name"]),
            ':description'            =>    $object->clean_input($_POST["description"]),
            ':photo'            =>    $post_photo
        );
    
        $object->query = "
            UPDATE posts  
            SET type = :type, 
            title = :title, 
            tag = :tag, 
            writerName = :writerName, 
            description = :description, 
            photo = :photo 
            WHERE id = '" . $_POST['hidden_id'] . "'
        ";
    
        $object->execute($data);
    
        $success = '<div class="alert alert-success">Post Edited Successfully</div>';
    } else {
        $error = 'already_accepted';
    }

    $output = array(
        'error'        =>    $error,
        'success'    =>    $success
    );

    echo json_encode($output);
}


function upload_image()
{
	if(isset($_FILES["post_photo"]))
	{
		$extension = explode('.', $_FILES['post_photo']['name']);
		$new_name = rand() . '.' . $extension[1];
		$destination = './images/' . $new_name;
		move_uploaded_file($_FILES['post_photo']['tmp_name'], $destination);
		return $destination;
	}
}
