<?php

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quote = new Quote($db);

    // Function to get quotes by author_id
    function getQuotesByAuthorId($author_id, $quoteObject) {
        return $quoteObject->getQuotesByAuthorId($author_id);
    }

    // Function to get quotes by category_id
    function getQuotesByCategoryId($category_id, $quoteObject) {
        return $quoteObject->getQuotesByCategoryId($category_id);
    }

    // Function to get quotes by author_id && category_id
    function getQuotesByAuthorAndCategory($author_id, $category_id, $quoteObject) {
        return $quoteObject->getQuotesByAuthorAndCategory($author_id, $category_id);
    }

    // Check what is provided
    if (isset($_GET['author_id']) && isset($_GET['category_id'])) {
        $author_id = intval($_GET['author_id']);
        $category_id = intval($_GET['category_id']);
        $result = getQuotesByAuthorAndCategory($author_id, $category_id, $quote);
    } elseif (isset($_GET['author_id'])) {
        $author_id = intval($_GET['author_id']);
        $result = getQuotesByAuthorId($author_id, $quote);
    } elseif (isset($_GET['category_id'])) {
        $category_id = intval($_GET['category_id']);
        $result = getQuotesByCategoryId($category_id, $quote);
    } else {
        $result = $quote->read();
    }

    // Get Row Count
    $num = $result->rowCount();

    // Initialize an empty array to store quotes
    $quotes_arr = array();

    // Check if any Quotes
    if ($num > 0) {
        $quotes_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $quote_id,
                'quote' => $quote_text, // Fixed: Changed 'quote' to 'quote_text'
                'author' => $author_name,
                'category' => $category_name
            );

            // Push to "data"
            $quotes_arr['data'][] = $quote_item;
        }
        echo json_encode($quotes_arr);
    } else {
        echo json_encode(['message' => 'No Quotes Found']); // Fixed: Return JSON message properly
    }

