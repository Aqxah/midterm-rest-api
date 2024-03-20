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

    // Check if the author field is set
    if (!isset($data->author)) {
        echo json_encode(['message' => 'Missing Required Parameters']);
    } else {
        $author->id = $data->id;
        $author->author = $data->author;

        $createdAuthor = $author->create();
        return json_encode($createdAuthor);
    }