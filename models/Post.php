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

    //Read single post.
    public function read_single() {
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
            WHERE 
                p.id = ?
            LIMIT 0,1";

        // Create Prepared Statment
        $stmt = $this->conn->prepare($query);

        //Bind Params
        $stmt->bindParam(1, $this->id);

        //Execute the query.
        $stmt->execute();

        //Fetch the result from the query.
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_name = $row['category_name'];
        $this->category_id = $row['category_id'];
    }

    //Create a post
    public function create() {
        //Create a query for creating a post
        $query = "INSERT INTO 
                $this->table(title, body, author, category_id)
            VALUES 
                (:title, :body, :author, :category_id)";

        //Prepare a statement for the query.
        $stmt = $this->conn->prepare($query);
        
        //Clean Data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //Bind Param
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        //execute the query
        if($stmt->execute()){
            return true;
        } 

        //Print error if something went wrong.
        printf("ERROR: %s.\n", $stmt->error);
        return false;

    }
    
}