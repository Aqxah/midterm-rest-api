<?php

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quote = new Quote($db);

    // Quote Query
    $result = $quote->read();
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
        echo json_encode(array('message' => 'No Quotes Found'));
    }

