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
    $result = $quoteObject->getQuotesByAuthorId($author_id);
    return $result;
    }

    // Function to get quotes by category_id
    function getQuotesByCategoryId($category_id, $quoteObject) {
    $result = $quoteObject->getQuotesByCategoryId($category_id);
    return $result;
    }

    // Function to get quotes by author_id && category_id
    function getQuotesByAuthorAndCategory($author_id, $category_id, $quoteObject) {
    $result = $quoteObject->getQuotesByAuthorAndCategory($author_id, $category_id);
    return $result;
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

    // Check if any Quotes
    if($num > 0) {
        $quotes_arr = array();
        $quotes_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $quote_id,
                'quote' => $quote,
                'author' => $author_name,
                'category' => $category_name
            );

            // Push to "data"
            array_push($quotes_arr['data'], $quote_item);
        }
        // Turn to JSON & Output
        echo json_encode($quotes_arr);

    } else {
        echo json_encode(['message' => 'No Quotes Found']);
    }

