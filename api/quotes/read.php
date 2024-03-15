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

    // Initialize an empty array to store quotes
    $quotes_arr = array();

    // Fetch result
    if ($result) {
        // Check if there are at least 25 quotes
        if ($result->rowCount() < 25) {
            echo json_encode(['message' => 'Not enough quotes available']);
            exit(); // Exit script after echoing the message
        }

        // Loop through the result and add to array
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $quote_item = array(
                'id' => $row['quote_id'],
                'quote' => $row['quote'], 
                'author' => $row['author_name'],
                'category' => $row['category_name']
            );

            // Push quote to "data" array
            $quotes_arr[] = $quote_item;
        }

        // Return JSON data
        echo json_encode($quotes_arr);
    } else {
        echo json_encode(['message' => 'No quotes found']);
    }