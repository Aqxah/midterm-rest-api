<?php 

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quote = new Quote($db);

    // Get Raw Data
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->id)) {
        echo json_encode(['message' => 'No Quotes Found']);
    }

    // Delete ID
    $quote->id = $data->id;

    // Delete
    if($quote->Delete()) {
        echo json_encode(array('message' => 'Quote Deleted', 'id' => $quote->id));
    } else {
        echo json_encode(array('message' => 'No Quotes Found'));
    }