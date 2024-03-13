<?php 

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author Object
    $author = new Author($db);

    // Get ID
    $author->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Author
    $author->read_single();

    // Create Array
    $author_arr = array(
        'id' => $author->id,
        'author' => $author->author
    );

    // Convert to JSON
    print_r(json_encode($author_arr));