<?php
class BookArray {
	public $books;
	public $err;
	function __construct() {
		try {
			$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
			$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$query = "SELECT * FROM books";
			$stmt = $con->prepare( $query );
			$stmt->execute();
			$result = $stmt->fetchAll();
			$this->books = $result;
		} catch ( PDOException $e ) {
			//echo $e->getMessage();
			$this->err = "Server down. Please try again later.";
		}
	}
}