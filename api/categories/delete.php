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
        exit;
    }

    // Update ID
    $category->id = $data->id;

    // Delete
    if ($category->delete()) {
        // Category deleted successfully, return JSON response with deleted ID
        echo json_encode(['id' => $data->id]);
    } else {
        }