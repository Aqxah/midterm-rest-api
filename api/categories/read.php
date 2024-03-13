<?php 

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Cateogry Object
    $category = new Category($db);

    // Category Query
    $result = $category->read();
    // Get Row Count
    $num = $result->rowCount();

    // Check if any Categories
    if($num > 0) {
        $categories_arr = array();
        $categories_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $category_item = array(
                'id' => $id,
                'category' => $category
            );

            // Push to "data"
            array_push($categories_arr['data'], $category_item);
        }
        http_response_code(200);
        // Turn to JSON & Output
        echo json_encode($categories_arr);

    } else {
        http_response_code(404);
        echo json_encode(array('message' => 'No Categories Found'));
    }