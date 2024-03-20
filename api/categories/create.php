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

    // Check if the category field is set
    if (!isset($data->category)) {
        echo json_encode(['message' => 'Missing Required Parameters']);
    } else {
        $category->category = $data->category;
        $category->id = $data->id;

        $createdCategory = $category->create();
        return json_encode($createdCategory);
    }