<?php
class Transaction {
    public $uid = 1;
    public $user = null;
    public $addr1 = null;
    public $addr2 = null;
    public $city = null;
    public $state = null;
    public $zip = null;
    public $credit = null;
    public $expire = null;
    public $cart = null;
	public $salt = "Zo4rU5Z1YyKJAASY0PT6EUg7BBYdlEhPaNLuxAwU8lqu1ElzHv0Ri7EM6irpx5w";

	public function __construct( $data = array(), $cart, $uid ) {
		if( isset( $data['addr1'] ) ) $this->username = stripslashes( strip_tags( $data['addr1'] ) );
		if( isset( $data['addr2'] ) ) $this->password = stripslashes( strip_tags( $data['addr2'] ) );
		if( isset( $data['city'] ) ) $this->name = stripslashes( strip_tags( $data['city'] ) );
		if( isset( $data['state'] ) ) $this->name = stripslashes( strip_tags( $data['state'] ) );
		if( isset( $data['zip'] ) ) $this->name = stripslashes( strip_tags( $data['zip'] ) );
		if( isset( $data['credit'] ) ) $this->name = stripslashes( strip_tags( $data['credit'] ) );
		if( isset( $data['expire'] ) ) $this->name = stripslashes( strip_tags( $data['expire'] ) );
		$this->cart = $cart;
	}

	public function storeFormValues( $post_params, $cart_params, $uid ) {
		//store the parameters
		$this->__construct( $post_params, $cart_params, $uid );
	}

	public function post_order($data, $cart) {
		$correct = false;
		try {
			$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
			$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$sql = "INSERT INTO transactions(userID, addr1, addr2, city, state, zip, credit, expire) VALUES(:userID, :addr1, :addr2, :city, :state, :zip, :credit, :expire)";

			$stmt = $con->prepare( $sql );
			$stmt->bindValue( "userID", $this->uid, PDO::PARAM_INT );
			$stmt->bindValue( "addr1", $data['addr1'], PDO::PARAM_STR );
			$stmt->bindValue( "addr2", $data['addr2'], PDO::PARAM_STR );
			$stmt->bindValue( "city", $data['city'], PDO::PARAM_STR );
			$stmt->bindValue( "state", $data['state'], PDO::PARAM_STR );
			$stmt->bindValue( "zip", $data['zip'], PDO::PARAM_STR );
			$stmt->bindValue( "credit", hash("sha256", $data['password'] . $this->salt), PDO::PARAM_STR );
			$stmt->bindValue( "expire", $data['expire'], PDO::PARAM_STR );
			$stmt->execute();
			$tran_id = $con->lastInsertId();
			foreach ($cart as $prod_id => $prod_qty) {
				$sql = "INSERT INTO purchases(tranID, bookID, qty) VALUES(:tranID, :bookID, :qty)";
				$stmt = $con->prepare( $sql );
				$stmt->bindValue( "tranID", $tran_id, PDO::PARAM_INT );
				$stmt->bindValue( "bookID", $prod_id, PDO::PARAM_INT );
				$stmt->bindValue( "qty", $prod_qty, PDO::PARAM_INT );
				$stmt->execute();

				$sql = "SELECT quantity FROM books WHERE bookID = :bookID";
				$stmt = $con->prepare( $sql );
				$stmt->bindValue( "bookID", $prod_id, PDO::PARAM_INT );
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_NUM);
				$old_qty = $result[0];
				$new_qty = $old_qty - $prod_qty;

				$sql = "UPDATE books SET quantity = :quantity WHERE bookID = :bookID";
				$stmt = $con->prepare( $sql );
				$stmt->bindValue( "quantity", $new_qty, PDO::PARAM_INT );
				$stmt->bindValue( "bookID", $prod_id, PDO::PARAM_INT );
				$stmt->execute();
			}

			$con = null;
			return $tran_id;
		} catch( PDOException $e ) {
			//echo $e->getMessage();
			return false;
		}
	}
}
