<?php

class Post {
    //DB Stuff
    private $conn;
    private $table = 'posts';

    // Post Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // Create Contractor with DB
    // CONTRACTOR - will run automatically when we intantiate the class.
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get Post
    public function read() {
        // Create a query
        $query = "SELECT
                c.name as category_name, 
                p.id,
                p.title,
                p.category_id,
                p.body,
                p.author,
                p.created_at
            FROM 
                $this->table p
            LEFT JOIN 
                categories c ON p.category_id = c.id
            ORDER BY 
                p.created_at
            DESC";

        // Create Prepared Statment
        $stmt = $this->conn->prepare($query);

        // Execute the query
        $stmt->execute();

        return $stmt;
    }
    
}