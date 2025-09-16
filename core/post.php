<?php
class Post {
    // DB stuff
    private $conn;
    private $table = 'posts';

    // post xassələri
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // verilənlər bazasından məlumatları əldə edirik ready() metodu ilə.
    public function read() {
        // Sorğu yaradırıq
        $query = 'SELECT 
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at FROM '.$this->table . ' p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC';

        // prepare statement 
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();

        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT 
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at FROM '.$this->table . ' p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title         = $row['title'];
        $this->body          = $row['body'];
        $this->author        = $row['author'];
        $this->category_id   = $row['category_id'];
        $this->category_name = $row['category_name'];

        // return $stmt;
    }




    public function create() {
        $query = 'INSERT INTO ' . $this-table . ' title = :title, body = :body, author = :author, category_id = :category_id,';
    }
}