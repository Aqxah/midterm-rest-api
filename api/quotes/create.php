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

    // Check if the required parameters exist
    if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
        echo json_encode(['message' => 'Missing Required Parameters']);
    } else {
        // Set the quote properties
        $quote->quote = $data->quote;
        $quote->author_id = $data->author_id;
        $quote->category_id = $data->category_id;

        // Create the quote
        $createdQuote = $quote->create();

        // Check if the quote was created successfully
        if ($createdQuote) {
            echo json_encode($createdQuote);
        } else {
            echo json_encode(['message' => 'Failed to create quote']);
        }
    }