<?php 

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $category = new Category($db);

    // Get Raw Data
    $data = json_decode(file_get_contents("php://input"));

    // Check if the id and category fields are set
    if (!isset($data->id) || !isset($data->category)) {
        echo json_encode(['message' => 'Missing Required Parameters']);
    } else {
        // Set properties
        $category->id = $data->id;
        $category->category = $data->category;

        // Update the category
        $updateCategory = $category->update();
        return json_encode($updateCategory);
    }