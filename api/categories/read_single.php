<?php 

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Catgory Object
    $category = new Category($db);

    // Get ID
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Category
    $category->read_single();

    // Create Array
    $category_arr = array(
        'id' => $category->id,
        'category' => $category->category
    );

    // Convert to JSON
    print_r(json_encode($category));