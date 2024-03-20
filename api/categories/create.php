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
        // Set the category property
        $category->category = $data->category;

        // Create the category
        $createdCategory = $category->create();

        // Check if the category was created successfully
        if ($createdCategory) {
            // Return JSON response with the created category data
            echo json_encode(['id' => $data->id]);
        } else {
            // Handle the case where the category creation failed
            echo json_encode(['message' => 'Failed to create category']);
        }
    }