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
        // Set the author property
        $author->author = $data->author;

        // Create the author
        $createdAuthor = $author->create();

        // Check if the author was created successfully
        if ($createdAuthor) {
            // Return JSON response with the created author data
            echo json_encode($createdAuthor);
        } else {
            // Handle the case where the author creation failed
            echo json_encode(['message' => 'Failed to create author']);
        }
    }