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

    if (!isset($data->id)) {
        echo json_encode(['message' => 'No Category Found']);
    }

    // Update ID
    $category->id = $data->id;

    // Delete
    if($category->Delete()) {
        echo json_encode(array('message' => 'Category Deleted', 'id' => $category->id));
    } else {
        echo json_encode(array('message' => 'Category Not Deleted'));
    }