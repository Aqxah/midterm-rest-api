<?php 
    
    // This file will contain the function to determine what api folder needs to be accessed

    /*
    In my index.php I handle some conditionals before routing. 

    For example, all HTTP methods except for POST need to confirm the id if submitted. That makes it a good place to add a conditional along the lines of: 
    If the method is not equal to POST and the id was submitted, then verify the author actually exists in your database. 
    From there, I created a helper function called isValid that verifies something is in a database related to an id. It returns a Boolean
    */

    function determineApiFolder($resource) {
    
        // Check the HTTP method and handle the request accordingly
        switch ($resource) {
            case 'quotes':
                include_once 'api/quotes/';
                break;
            case 'categories':
                include_once 'api/categories/';
                break;
            case 'authors':
                include_once 'api/authors/';
                break;
            default:
                http_response_code(405); // Method Not Allowed
                echo json_encode(['message' => 'Method not supported']);
                break;
        }
    }
    
    // Call the function to determine the API folder
    determineApiFolder($resource);