<?php
class Users {
	public $uid = null;
	public $username = null;
	public $password = null;
	public $name = null;
	public $dateUpdated = null;
	public $salt = "Zo4rU5Z1YyKJAASY0PT6EUg7BBYdlEhPaNLuxAwU8lqu1ElzHv0Ri7EM6irpx5w";

	public function __construct( $data = array() ) {
		if( isset( $data['username'] ) ) $this->username = stripslashes( strip_tags( $data['username'] ) );
		if( isset( $data['password'] ) ) $this->password = stripslashes( strip_tags( $data['password'] ) );
		if( isset( $data['name'] ) ) $this->name = stripslashes( strip_tags( $data['name'] ) );
	}

	public function storeFormValues( $params ) {
		//store the parameters
		$this->__construct( $params );
	}

	public function userLogin() {
		$success = false;
		try {
			$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
			$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$sql = "SELECT * FROM users WHERE username = :username AND password = :password LIMIT 1";

			$stmt = $con->prepare( $sql );
			$stmt->bindValue( "username", $this->username, PDO::PARAM_STR );
			$stmt->bindValue( "password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR );
			$stmt->execute();

			$result = $stmt->fetch(PDO::FETCH_NUM);
			if( $result )  $success = true;

			$this->uid = $result[0];
			$this->name = $result[3];
			$this->dateUpdated = $result[4];

			$con = null;
			return $success;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function register() {
		try {
			$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
			$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$sql = "INSERT INTO users(username, password, name, updated) VALUES(:username, :password, :name, :updated)";

			$stmt = $con->prepare( $sql );
			$stmt->bindValue( "username", $this->username, PDO::PARAM_STR );
			$stmt->bindValue( "password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR );
			$stmt->bindValue( "name", $this->name, PDO::PARAM_STR );
			$stmt->bindValue( "updated", time(), PDO::PARAM_INT );
			$success = $stmt->execute(); // Returns true or false based on success.

			$con = null;
			return $success;
		} catch( PDOException $e ) {
			return false;
		}
	}

	public function reset() {
		try {
			$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
			$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$sql = "UPDATE users SET password = :password , updated = :updated WHERE username = :username";

			$stmt = $con->prepare( $sql );
			echo "uu" . $this->username;
			echo "pp" . $this->password;
			$stmt->bindValue( "password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR );
			$stmt->bindValue( "updated", time(), PDO::PARAM_INT );
			$stmt->bindValue( "username", $this->username, PDO::PARAM_STR );
			$success = $stmt->execute();

			$con = null;
			return $success;
		} catch( PDOException $e ) {
			echo $e;
			return false;
		}
	}

	public function get_details() {
	}
}