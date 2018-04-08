<?php

class BookSpecific {
    public $id;
    public $title;
    public $author;
    public $year;
    public $description;
    public $cost;
    public $quantity;
    public $image;

    function __construct($inId=null) {
        if (!empty($inId)) {
            $this->id = stripslashes( strip_tags ( $inId ) );
            try {
                $con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
                $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                $query = "SELECT * FROM books WHERE bookID = :bookID LIMIT 1";
                $stmt = $con->prepare( $query );
                $stmt->bindValue( "bookID", $this->id, PDO::PARAM_INT );
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_NUM);
                $this->title = $result[1];
                if (substr($this->title, -3) == ", A") {
                    $this->title = "A " . substr($this->title,0,-3);
                } else if (substr($this->title, -5) == ", The") {
                    $this->title = "The " . substr($this->title,0,-5);
                }
                $this->author = $result[2];
                $this->year = $result[3];
                $this->description = $result[4];
                $this->cost = $result[5];
                $this->quantity = $result[6];
                $this->image = $result[7];
                $con = null;
            } catch ( PDOException $e ) {
                echo $e->getMessage();
                return $e->getMessage();
            }
        }
    }
}
