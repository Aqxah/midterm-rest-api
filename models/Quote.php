<?php
    class Quote {
        private $conn;
        private $table = 'quotes';

        public $id;
        public $quote;
        public $author_name;
        public $category_name;
        public $author_id;
        public $category_id;

        // Constructor w/ DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Quotes
        public function read() {
            $query = 'SELECT
            q.id AS quote_id,
            q.quote,
            a.author AS author_name,
            c.category AS category_name
        FROM 
            ' . $this->table . ' q
        JOIN 
            authors a ON q.author_id = a.id
        JOIN 
            categories c ON q.category_id = c.id';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Execute Query
        $stmt->execute();

        // Fetch data as associative array
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if the result is empty
        if (empty($result)) {
            return json_encode(['message' => 'No Quotes Found']);
        }

        // Initialize an empty array to store quotes
        $quotes_arr = array();

        // Loop through the result and add to array
        foreach ($result as $row) {
            $quote_item = array(
                'id' => $row['quote_id'],
                'quote' => $row['quote'], 
                'author' => $row['author_name'],
                'category' => $row['category_name']
            );

            // Push quote to "data" array
            $quotes_arr[] = $quote_item;
        }

        // Return JSON data
        return json_encode($quotes_arr);
        }

        // Get Quotes By Author_Id
        public function getQuotesByAuthorId($author_id) {
            $query = 'SELECT
            q.id AS quote_id,
            q.quote,
            a.author AS author_name,
            c.category AS category_name
        FROM 
            ' . $this->table . ' q
        JOIN 
            authors a ON q.author_id = a.id
        JOIN 
            categories c ON q.category_id = c.id
        WHERE
            author_id = :author_id';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Bind Author_Id
        $stmt->bindParam(':author_id', $author_id);

        // Execute Query
        $stmt->execute();

        // Fetch data as associative array
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if the result is empty
        if (empty($result)) {
            return json_encode(['message' => 'No Quotes Found']);
        }

        // Initialize an empty array to store quotes
        $quotes_arr = array();

        // Loop through the result and add to array
        foreach ($result as $row) {
            $quote_item = array(
                'id' => $row['quote_id'],
                'quote' => $row['quote'], 
                'author' => $row['author_name'],
                'category' => $row['category_name']
            );

            // Push quote to "data" array
            $quotes_arr[] = $quote_item;
        }

        // Return JSON data
        return json_encode($quotes_arr);
        }

        // Get Quotes By Category_Id
        public function getQuotesByCategoryId($category_id) {
            $query = 'SELECT
            q.id AS quote_id,
            q.quote,
            a.author AS author_name,
            c.category AS category_name
        FROM 
            ' . $this->table . ' q
        JOIN 
            authors a ON q.author_id = a.id
        JOIN 
            categories c ON q.category_id = c.id
        WHERE
            category_id = :category_id';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Bind Category_Id
        $stmt->bindParam(':category_id', $category_id);

        // Execute Query
        $stmt->execute();

        // Fetch data as associative array
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if the result is empty
        if (empty($result)) {
            return json_encode(['message' => 'No Quotes Found']);
        }

        // Initialize an empty array to store quotes
        $quotes_arr = array();

        // Loop through the result and add to array
        foreach ($result as $row) {
            $quote_item = array(
                'id' => $row['quote_id'],
                'quote' => $row['quote'], 
                'author' => $row['author_name'],
                'category' => $row['category_name']
            );

            // Push quote to "data" array
            $quotes_arr[] = $quote_item;
        }

        // Return JSON data
        return json_encode($quotes_arr);
        }

        // Get Quotes By author_id && category_id
        public function getQuotesByAuthorAndCategory($author_id, $category_id) {
            $query = 'SELECT
            q.id AS quote_id,
            q.quote,
            a.author AS author_name,
            c.category AS category_name
        FROM 
            ' . $this->table . ' q
        JOIN 
            authors a ON q.author_id = a.id
        JOIN 
            categories c ON q.category_id = c.id
        WHERE
            author_id = :author_id AND
            category_id = :category_id';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Bind Category_Id & Author_Id
        $stmt->bindParam(':author_id', $author_id);
        $stmt->bindParam(':category_id', $category_id);

        // Execute Query
        $stmt->execute();

        // Fetch data as associative array
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if the result is empty
        if (empty($result)) {
            return json_encode(['message' => 'No Quotes Found']);
        }

        // Initialize an empty array to store quotes
        $quotes_arr = array();

        // Loop through the result and add to array
        foreach ($result as $row) {
            $quote_item = array(
                'id' => $row['quote_id'],
                'quote' => $row['quote'], 
                'author' => $row['author_name'],
                'category' => $row['category_name']
            );

            // Push quote to "data" array
            $quotes_arr[] = $quote_item;
        }

        // Return JSON data
        return json_encode($quotes_arr);
        }

        // Get Single Quote
        public function read_single() {
            $query = 'SELECT
            q.id AS quote_id,
            q.quote,
            a.author AS author_name,
            c.category AS category_name
        FROM 
            ' . $this->table . ' q
        JOIN 
            authors a ON q.author_id = a.id
        JOIN 
            categories c ON q.category_id = c.id
        WHERE 
            q.id = ?
        LIMIT 1 OFFSET 0';
    
        // Prepare Statement
        $stmt = $this->conn->prepare($query);
    
        // Bind ID
        $stmt->bindParam(1, $this->id);
    
        // Execute Query
        $stmt->execute();

        // Check if any Quotes
        if ($stmt->rowCount() === 0 ) {
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Set Properties
        $this->quote = $row['quote'];
        $this->author_name = $row['author_name'];
        $this->category_name = $row['category_name'];

        return $stmt;
        }

    // Create Quote
    public function create() {
        // Check if author_id, category_id, and quote exist
        if (empty($this->author_id) || empty($this->category_id) || empty($this->quote)) {
            http_response_code(400); // Bad Request
            echo json_encode(['message' => 'Missing Required Parameters']);
            return false;
        }

        // Query to check if the author_id exists in the authors table
        $authorCheckQuery = "SELECT id FROM authors WHERE id = :author_id";
        $authorCheckStmt = $this->conn->prepare($authorCheckQuery);
        $authorCheckStmt->bindParam(':author_id', $this->author_id);
        $authorCheckStmt->execute();

        // Check if the author_id exists in the authors table
        if ($authorCheckStmt->rowCount() === 0) {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'Author Not Found']);
            return false;
        }

        // Query to check if the category_id exists in the categories table
        $categoryCheckQuery = "SELECT id FROM categories WHERE id = :category_id";
        $categoryCheckStmt = $this->conn->prepare($categoryCheckQuery);
        $categoryCheckStmt->bindParam(':category_id', $this->category_id);
        $categoryCheckStmt->execute();

        // Check if the category_id exists in the categories table
        if ($categoryCheckStmt->rowCount() === 0) {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'Category Not Found']);
            return false;
        }

        // Proceed with inserting the quote into the quotes table
        $query = 'INSERT INTO ' . $this->table . '
                SET
                    quote = :quote,
                    author_id = :author_id,
                    category_id = :category_id';

        // Prepare the SQL statement
        $stmt = $this->conn->prepare($query);

        // Clean and bind parameters
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        // Execute the SQL statement
        if ($stmt->execute()) {
            // Get last inserted ID
            $quote_id = $this->conn->lastInsertId();

            // Return created quote
            http_response_code(201); // Created
            $created_quote = [
                'id' => $quote_id,
                'quote' => $this->quote,
                'author_id' => $this->author_id,
                'category_id' => $this->category_id
            ];
            echo json_encode($created_quote);
            return true;
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Quote Not Created']);
            return false;
        }
    }

        // Update Quote
        public function update() {
            // Check if author_id and category_id exist
            if (!empty($this->author_id) && !empty($this->category_id)) {
                // Check if author_id exists
                $authorCheckQuery = "SELECT id FROM authors WHERE id = :author_id";
                $authorCheckStmt = $this->conn->prepare($authorCheckQuery);
                $authorCheckStmt->bindParam(':author_id', $this->author_id);
                $authorCheckStmt->execute();

                if ($authorCheckStmt->rowCount() === 0) {
                    // Return an error message indicating that the author ID was not found
                    echo json_encode(['message' => 'author_id Not Found']);
                    return false;
                }

                // Check if category_id exists
                $categoryCheckQuery = "SELECT id FROM categories WHERE id = :category_id";
                $categoryCheckStmt = $this->conn->prepare($categoryCheckQuery);
                $categoryCheckStmt->bindParam(':category_id', $this->category_id);
                $categoryCheckStmt->execute();

                if ($categoryCheckStmt->rowCount() === 0) {
                    // Return an error message indicating that the category ID was not found
                    echo json_encode(['message' => 'category_id Not Found']);
                    return false;
                }
            }
            // Proceed with updating the quote
            $query = 'UPDATE ' . $this->table . '
              SET
                quote = :quote,
                author_id = :author_id,
                category_id = :category_id
              WHERE
                id = :id';
      
            // Prepare the SQL statement
            $stmt = $this->conn->prepare($query);
      
            // Clean and bind parameters
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));
    
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);
      
            // Execute the SQL statement
            if($stmt->execute()) {
                echo json_encode(['message' => 'Quote Updated']);
                return true;
            } else {
                echo json_encode(['message' => 'No Quotes Found']);
                return false;
            }
        }

        // Delete Quote
        public function delete() {
            // Query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
    
            // Prepare
            $stmt = $this->conn->prepare($query);
    
            // Clean
            $this->id = htmlspecialchars(strip_tags($this->id));
    
            // Bind
            $stmt->bindParam(':id', $this->id);
    
            // Execute
            if($stmt->execute()) {
                if ($stmt->rowCount() > 0 ) {
                    return true;
                } else {
                    return false;
                } 
            } else {
                printf("Error: %s. \n", $stmt->error);
                return false;
            }
        }
    }
