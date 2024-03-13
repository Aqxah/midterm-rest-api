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

    // Update ID
    $author->id = $data->id;

    $author->author = $data->author;

    // Update 
    if($author->update()) {
        echo json_encode(array('message' => 'Author Updated'));
    } else {
        echo json_encode(array('message' => 'Author Not Updated'));
    }