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

    $author->author = $data->author;

    // Create 
    if($author->create()) {
        echo json_encode(array('message' => 'Author Created'));
    } else {
        echo json_encode(array('message' => 'Author Not Created'));
    }