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

        return $stmt;
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
        LIMIT 0,1';
    
        // Prepare Statement
        $stmt = $this->conn->prepare($query);
    
        // Bind ID
        $stmt->bindParam(1, $this->id);
    
        // Exectue Query
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Set Properties
        $this->quote = $row['quote'];
        $this->author_name = $row['author_name'];
        $this->category_name = $row['category_name'];
        }

        // Create Quote
        public function create() {
            $query = 'INSERT INTO ' . $this->table . '
              SET
                quote = :quote,
                author_id = :author_id,
                category_id = :category_id';
      
            // Prepare
            $stmt = $this->conn->prepare($query);
      
            // Clean
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
      
            // Bind
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
      
            // Execute
            if($stmt->execute()) {
              return true;
            }
      
            // Print Error If Goes Wrong
            printf("Error: %s. \n", $stmt->error);
      
            return false;
        }

        // Update Quote
        public function update() {
            $query = 'UPDATE ' . $this->table . '
              SET
                quote = :quote,
                author_id = :author_id,
                category_id = :category_id
              WHERE
                id = :id';
      
            // Prepare
            $stmt = $this->conn->prepare($query);
      
            // Clean
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));
      
            // Bind
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);
      
            // Execute
            if($stmt->execute()) {
              return true;
            }
      
            // Print Error If Goes Wrong
            printf("Error: %s. \n", $stmt->error);
      
            return false;
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
            return true;
            }
    
            // Print Error If Goes Wrong
            printf("Error: %s. \n", $stmt->error);
    
            return false;
        }
  
    }
