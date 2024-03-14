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
                LIMIT 0,1';

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
      if($stmt->execute()) {
        return true;
      }

      // Print Error If Goes Wrong
      printf("Error: %s. \n", $stmt->error);

      return false;
    }

    // Update Author
    public function update() {
      $query = 'UPDATE ' . $this->table . '
        SET
          author = :author
        WHERE
          id = :id';

      // Prepare
      $stmt = $this->conn->prepare($query);

      // Clean
      $this->author = htmlspecialchars(strip_tags($this->author));
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind
      $stmt->bindParam(':author', $this->author);
      $stmt->bindParam(':id', $this->id);

      // Execute
      if($stmt->execute()) {
        return true;
      }

      // Print Error If Goes Wrong
      printf("Error: %s. \n", $stmt->error);

      return false;
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
        return true;
      }

      // Print Error If Goes Wrong
      printf("Error: %s. \n", $stmt->error);

      return false;
    }

  }