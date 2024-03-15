<?php

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quote = new Quote($db);

    // Check what is provided
    if (isset($_GET['author_id']) && isset($_GET['category_id'])) {
        $author_id = intval($_GET['author_id']);
        $category_id = intval($_GET['category_id']);
        $result = $quote->getQuotesByAuthorAndCategory($author_id, $category_id);
    } elseif (isset($_GET['author_id'])) {
        $author_id = intval($_GET['author_id']);
        $result = $quote->getQuotesByAuthorId($author_id);
    } elseif (isset($_GET['category_id'])) {
        $category_id = intval($_GET['category_id']);
        $result = $quote->getQuotesByCategoryId($category_id);
    } else {
        $result = $quote->read();
    }

    // Return the result
    echo $result;