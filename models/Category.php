<?php
    class Category {
        private $conn;
        private $table = 'categories';

        public $id;
        public $category;

        // Constructor w/ DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Categories
        public function read() {
            $query = 'SELECT 
                        id, 
                        category
                      FROM
                        ' . $this->table . '
                      ';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Exectue Query
        $stmt->execute();

        return $stmt;
        }

    // Get Single Category
    public function read_single() {
      $query = 'SELECT 
                  id, 
                  category
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

    // Check if any Category
    if ($stmt->rowCount() === 0 ) {
      return null;
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set Properties
    $this->category = $row['category'];

    return $stmt;
    }

    // Create Category
    public function create() {
      $query = 'INSERT INTO ' . $this->table . '
        SET
          category = :category';

      // Prepare
      $stmt = $this->conn->prepare($query);

      // Clean
      $this->category = htmlspecialchars(strip_tags($this->category));

      // Bind
      $stmt->bindParam(':category', $this->category);

      // Execute
      if($stmt->execute()) {
        return true;
      }

      // Print Error If Goes Wrong
      printf("Error: %s. \n", $stmt->error);

      return false;
    }

    // Update category
    public function update() {
      $query = 'UPDATE ' . $this->table . '
        SET
        category = :category
        WHERE
          id = :id';

      // Prepare
      $stmt = $this->conn->prepare($query);

      // Clean
      $this->category = htmlspecialchars(strip_tags($this->category));
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind
      $stmt->bindParam(':category', $this->category);
      $stmt->bindParam(':id', $this->id);

      // Execute
      if($stmt->execute()) {
        return true;
      }

      // Print Error If Goes Wrong
      printf("Error: %s. \n", $stmt->error);

      return false;
    }

    // Delete category
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