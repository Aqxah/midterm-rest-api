<?php 

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author Object
    $author = new Author($db);

    // Author Query
    $result = $author->read();
    // Get Row Count
    $num = $result->rowCount();

    // Check if any Authors
    if ($num > 0) {
        $authors_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $author_item = array(
                'id' => $id,
                'author' => $author
            );

            // Push to "data"
            array_push($authors_arr, $author_item);
        }

        http_response_code(200);
        // Turn to JSON & Output
        echo json_encode($authors_arr);
    } else {
        http_response_code(404);
        echo json_encode(array('message' => 'No Authors Found'));
    }