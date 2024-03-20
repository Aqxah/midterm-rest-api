<?php
    class Author {
        private $conn;
        private $table = 'authors';

        public $id;
        public $author;

        // Constructor w/ DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Authors
        public function read() {
            $query = 'SELECT 
                        id, 
                        author
                      FROM
                        ' . $this->table . '
                      ';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Exectue Query
        $stmt->execute();

        return $stmt;
        }

    // Get Single Author
    public function read_single() {
      $query = 'SELECT 
                  id, 
                  author
                FROM
                  ' . $this->table . '
                WHERE
                  id = ?
                LIMIT 1 OFFSET 0';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->id);

    // Exectue Query
    $stmt->execute();

    // Check if any Authors
    if ($stmt->rowCount() === 0 ) {
      return null;
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set Properties
    $this->author = $row['author'];

    return $stmt;
    }

    // Create Author
    public function create() {
      // Check if the author field is set
      if (!isset($this->author)) {
          return false; // Return false if author field is not set
      }
  
      $query = 'INSERT INTO ' . $this->table . '
              SET
                author = :author';
  
      // Prepare
      $stmt = $this->conn->prepare($query);
  
      // Clean
      $this->author = htmlspecialchars(strip_tags($this->author));
  
      // Bind
      $stmt->bindParam(':author', $this->author);
  
      // Execute
      if ($stmt->execute()) {
          $author_id = $this->conn->lastInsertId();
          $createdAuthor = [
              'id' => $author_id,
              'author' => $this->author
          ];
          echo json_encode($createdAuthor);
          return true;
      } else {
          return false; // Return false if author is not created
      }
  }

    // Update author
    public function update() {
      // Check if author and id exist
      if (empty($this->author) || empty($this->id)) {
          echo json_encode(['message' => 'Missing Required Parameters']);
          return false;
      }

      // Update query
      $query = 'UPDATE ' . $this->table . '
                SET
                  author = :author
                WHERE
                  id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean and bind parameters
      $this->author = htmlspecialchars(strip_tags($this->author));
      $this->id = htmlspecialchars(strip_tags($this->id));
      $stmt->bindParam(':author', $this->author);
      $stmt->bindParam(':id', $this->id);

      // Execute the query
      if ($stmt->execute()) {
        // Fetch the updated author data
        $updatedAuthor = [
            'id' => $this->id,
            'author' => $this->author
        ];
        echo json_encode($updatedAuthor);
        return true;
      } else {
        echo json_encode(['message' => 'Author Not Updated']);
        return false;
      }
    }

    // Delete Author
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
        if($stmt->rowCount() > 0) {
            // Author deleted successfully, return JSON response with deleted ID
            return json_encode(['id' => $this->id]);
        } else {
            // No author found with the provided ID
            return json_encode(['message' => 'No Author Found']);
        }
    } else {
        // Error occurred during execution
        return json_encode(['message' => 'Error deleting author']);
    }
  }
}