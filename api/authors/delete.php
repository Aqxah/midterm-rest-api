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
        exit;
    }

    // Delete ID
    $author->id = $data->id;

    // Delete
    $result = $author->delete();
    if($result !== false) {
        echo json_encode(['message' => 'Author Deleted', 'id' => $author->id]);
    } else {
        echo json_encode(['message' => 'Author Not Deleted']);
    }