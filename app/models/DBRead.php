<?php 
	/**
	 * 
	 */
	require_once 'DBConn.php';
	class DBRead extends DBConn
	{
		
		function __construct(){
			parent::__construct();
		}
		
		function login($data){
			$email = mysqli_real_escape_string($this->conn, $data['email']);
			$password = mysqli_real_escape_string($this->conn, $data['password']);
			$query = "select * from login_details where email = '{$email}'";
			if($result = mysqli_query($this->conn, $query)){
				if(mysqli_num_rows($result) > 0){
				    $arr = mysqli_fetch_assoc($result);
			    	if(password_verify($password, $arr['password'])){
			    		$_SESSION['u_id'] = $arr['user_no'];
			    		if($arr['active'] == 0){
			    			$_SESSION['not_active'] = "Account need to (Re)Activated by making a Starter Pack Purchase.";
			    		}
			    		
			    		return array('status' => 'success');
			    		
			    	}else{

			    		return array('status' => 'failed', 'log' => 'Incorrect password');
			    		
			    	}
			    }else{
			    	return array('status' => 'failed', 'log' => 'Invalid email');
			    }
			}
			
			return array('status' => 'failed', 'log' => mysqli_error($this->conn));
		}
		function emailExists($email){
			$query = "select email from login_details where email = '{$email}' ";
			if($result = mysqli_query($this->conn, $query)){
				$num = mysqli_num_rows($result);
				if($num==1){
					$data = mysqli_fetch_assoc($result);
					return 1;
				}else{
					return 0;
				}
			}
		}
		function getUser($user_no){
			$query = "SELECT * FROM `users` where user_no = ? ";
			$stmt = $this->conn->prepare($query);
			$stmt->bind_param("s", $user_no);
			$stmt->execute();
			$results = $stmt->get_result();
			return mysqli_fetch_array($results);
		}
		function getAllUsers(){
			$query = "SELECT * FROM `users`";
			$results = mysqli_query($this->conn, $query);
			return $this->getStructureData($results);
		}

		
	}
?>