<?php 

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quote = new Quote($db);

    // Get ID
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Quote
    $result = $quote->read_single();

    if ($result === null) {
        echo json_encode(['message' => 'No Quotes Found']);
        exit;
    }

    $row = $result->fetch(PDO::FETCH_ASSOC);

    // Create Array
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author_name,
        'category' => $quote->category_name
    );

    // Convert to JSON
    print_r(json_encode($quote_arr));