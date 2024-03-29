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
      // Check if the category field is set
      if (!isset($this->category)) {
          return false; // Return false if category field is not set
      }
  
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
      if ($stmt->execute()) {
          $category_id = $this->conn->lastInsertId();
          $createdCategory = [
              'id' => $category_id,
              'category' => $this->category
          ];
          echo json_encode($createdCategory);
          return true;
      } else {
          return false; // Return false if category is not created
      }
  }

    // Update category
    public function update() {
      // Check if category and id exist
      if (!isset($this->category) || !isset($this->id)) {
          echo json_encode(['message' => 'Missing Required Parameters']);
          return false;
      }

      // Update query
      $query = 'UPDATE ' . $this->table . '
                SET
                  category = :category
                WHERE
                  id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean and bind parameters
      $this->category = htmlspecialchars(strip_tags($this->category));
      $this->id = htmlspecialchars(strip_tags($this->id));
      $stmt->bindParam(':category', $this->category);
      $stmt->bindParam(':id', $this->id);

      // Execute the query
      if ($stmt->execute()) {
        // Fetch the updated category data
        $updatedCategory = [
            'id' => $this->id,
            'category' => $this->category
        ];
        echo json_encode($updatedCategory);
        return true;
        } else {
          echo json_encode(['message' => 'Category Not Updated']);
          return false;
      }
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
        if($stmt->rowCount() > 0) {
            // Category deleted successfully, return JSON response with deleted ID
            return ['id' => $this->id];
        } else {
            // No Category found with the provided ID
            return ['message' => 'No Category Found'];
        }
    } else {
        // Error occurred during execution
        return ['message' => 'Error deleting category'];
    }
  }
}