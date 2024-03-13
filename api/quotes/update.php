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

    // Update ID
    $quote->id = $data->id;

    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Update 
    if($quote->update()) {
        echo json_encode(array('message' => 'Quote Updated'));
    } else {
        echo json_encode(array('message' => 'Quote Not Updated'));
    }