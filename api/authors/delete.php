<?php 

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author Object
    $author = new Author($db);

    // Get Raw Data
    $data = json_decode(file_get_contents("php://input"));

    // Delete ID
    $author->id = $data->id;

    // Delete
    if($author->Delete()) {
        echo json_encode(array('message' => 'Author Deleted'));
    } else {
        echo json_encode(array('message' => 'Author Not Deleted'));
    }