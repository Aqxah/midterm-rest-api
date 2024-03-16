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

    // Check if the id and author fields are set
    if (!isset($data->id) || !isset($data->author)) {
        echo json_encode(['message' => 'Missing Required Parameters']);
    } else {
        // Set properties
        $author->id = $data->id;
        $author->author = $data->author;

        // Update the author
        $updateAuthor = $author->update();
        return json_encode($updateAuthor);
    }