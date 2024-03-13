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
    $quote->read_single();

    // Create Array
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author_name,
        'category' => $quote->category_name
    );

    // Convert to JSON
    print_r(json_encode($quote_arr));