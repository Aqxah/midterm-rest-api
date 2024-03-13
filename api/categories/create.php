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

    $category->category = $data->category;

    // Create 
    if($category->create()) {
        echo json_encode(array('message' => 'Category Created'));
    } else {
        echo json_encode(array('message' => 'Category Not Created'));
    }