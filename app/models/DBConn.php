<?php 
	/**
	 * 
	 */
	class DBConn{
		public $conn;
		public $server = "localhost";
		private $username = "root";
		private $password = "";
		private $database = "db_name";
		public $_PRODUCT_IMAGE_DIRECTORY =  "public/images/";
		public $submit_keys = ['register', 'login'];
		function __construct(){
			try {
			    $this->conn = new Mysqli($this->server, $this->username, $this->password, $this->database);
			} catch (Exception $errormsg) {
			    echo $errormsg->getMessage();
			}
		}
		public function getStructureData( $results ){
			$data = array();
			while($tmp_data = mysqli_fetch_array($results)){
				$data[] = $tmp_data;
			}
			return $data;
		}
		public function validateData( $data_v ){
			$data_v = mysqli_real_escape_string($this->conn, $data_v);
			return $data_v;
		}
	}

 ?>