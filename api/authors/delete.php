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


    if (!isset($data->id)) {
        echo json_encode(['message' => 'No Author Found']);
    } else {
        $author->id = $data->id; // Set the ID to delete
        
        $deleteAuthor = $author->delete(); // Delete the author
        
        if ($deleteAuthor) {
            // Author deleted successfully, return JSON response with deleted ID
            echo json_encode(['id' => $data->id]);
            return true;
        } else {
            return false;
        }   
    }