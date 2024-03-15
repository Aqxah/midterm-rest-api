<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Midterm Rest API</title>
    </head>
    <body>
        <h1>Midterm Rest API Project</h1>
    </body>
    </html>

<?php 
    
    // This file will contain the function to determine what api folder needs to be accessed

    /*
    In my index.php I handle some conditionals before routing. 

    For example, all HTTP methods except for POST need to confirm the id if submitted. That makes it a good place to add a conditional along the lines of: 
    If the method is not equal to POST and the id was submitted, then verify the author actually exists in your database. 
    From there, I created a helper function called isValid that verifies something is in a database related to an id. It returns a Boolean
    

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];
    
    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }
    
    switch ($method) {
        case 'quotes':
            if ($method === 'GET' || $method === 'POST' || $method === 'PUT' || $method === 'DELETE')
            require 'api/quotes/';
            break;
        case 'categories':
            if ($method === 'GET' || $method === 'POST' || $method === 'PUT' || $method === 'DELETE')
            require 'api/categories/';
            break;
        case 'authors':
            if ($method === 'GET' || $method === 'POST' || $method === 'PUT' || $method === 'DELETE')
            require 'api/authors/';
            break;
        default:
            echo json_encode(array('message' => 'Method Not Supported'));
            break;
    }
    */
