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

    // Create the quote
    $createdQuote = $quote->create();

    if ($createdQuote) {
        // Return JSON response with the created quote data
        echo json_encode($createdQuote);
    } else {
        echo json_encode(['message' => 'Failed to create quote']);
    }