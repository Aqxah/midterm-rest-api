<?php 
    
    // This file will contain the function to determine what api folder needs to be accessed

    /*
    In my index.php I handle some conditionals before routing. 

    For example, all HTTP methods except for POST need to confirm the id if submitted. That makes it a good place to add a conditional along the lines of: 
    If the method is not equal to POST and the id was submitted, then verify the author actually exists in your database. 
    From there, I created a helper function called isValid that verifies something is in a database related to an id. It returns a Boolean
    */

    function routeToApiFolder($method, $resource, $id) {
        // Define the base API folder path
        $apiFolder = 'api/';
    
        // Determine the API folder based on the resource and method
        switch ($resource) {
            case 'quotes':
                if ($method === 'GET' || $method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
                    return $apiFolder . 'quotes/';
                }
                break;
            case 'authors':
                if ($method === 'GET' || $method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
                    return $apiFolder . 'authors/';
                }
                break;
            case 'categories':
                if ($method === 'GET' || $method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
                    return $apiFolder . 'categories/';
                }
                break;
            default:
                // Invalid resource
                return null;
        }
    
        // Invalid method for the given resource
        return null;
    }
    
    // Example usage:
    $method = $_SERVER['REQUEST_METHOD'];
    $resource = 'quotes'; // Assuming 'quotes' is the requested resource
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    
    $apiFolder = routeToApiFolder($method, $resource, $id);
    if ($apiFolder) {
        // Include the appropriate API file based on the determined folder
        include_once $apiFolder . 'index.php';
    } else {
        // Invalid resource or method
        http_response_code(404); // Not Found
        echo json_encode(['message' => 'Invalid API endpoint']);
    }