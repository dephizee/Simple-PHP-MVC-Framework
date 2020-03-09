<?php 
	/**
	 * 
	 */
	require_once 'DBConn.php';
	require_once 'DBRead.php';
	class DBWrite extends DBConn
	{
		private $write = null;
		function __construct(){
			parent::__construct();
			$this->read = new DBRead();
		}
		

		function registerUser($data){
			$first_name = $this->validateData( $data['first_name']);
			$last_name = $this->validateData( $data['last_name']);
			$phone_number = $this->validateData( $data['phone_number']);
			$phone_number = preg_replace("/^0/", "+234", $phone_number);
			$address = $this->validateData( $data['address']);
			$state_no = $this->validateData( $data['state_no']);
			$user_ref_no = $this->validateData( $data['user_ref_no']);
			$referral_code = $this->read->getReferralCode($first_name);
			$email = $this->validateData( $data['email']);
			$distri_no = $this->validateData( $data['distri_no']);
			$password = $this->validateData( $data['password']);
			$password = password_hash($password, PASSWORD_BCRYPT);
			foreach ($data as $key => $data_val) {
				if(in_array($key, $this->submit_keys)){
					continue;
				}
				if($data_val == '' ){
					return array('status' => 'failed', 'log' => mysqli_error($this->conn), 'error'=> $key. ' cannot be empty');
				}
			}

			
			$email_exist = $this->read->emailExists($email);
			if($email_exist !=0 ){
				return array('status' => 'failed', 'log' => mysqli_error($this->conn), 'error'=>'email already been used');
			}
			$query = "INSERT into users 
			(first_name, last_name, phone_number, address, state_no, referral_code, distri_no) VALUES 
			('{$first_name}', '{$last_name}', '{$phone_number}', '{$address}', '{$state_no}', '{$referral_code}', '{$distri_no}')";

			if($run_query = mysqli_query($this->conn, $query)){
				$user_no = mysqli_insert_id($this->conn);
				$login_details_query = "INSERT into login_details 
				(email, password, user_no) VALUES 
				('{$email}', '{$password}', '{$user_no}')";
				if($run_login_details_query = mysqli_query($this->conn, $login_details_query) 

					){
					$_SESSION['u_id'] = $user_no;
					$_SESSION['not_active'] = true;
					return $this->sendEmail($email, $first_name .' '. $last_name);

				}else{

					return array('status' => 'failed', 'log' => mysqli_error($this->conn), 'error'=>'Referrer error');
				}
			}else{
				return array('status' => 'failed', 'log' => mysqli_error($this->conn), 'error'=>'Unknown error');
			}

			return null;
		}
		function sendEmail($email, $name){
			
			$mail = new PHPMailer;
            $mail->isSMTP();          // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;          // Enable SMTP authentication
			$mail->Username = 'project_email';                
      		$mail->Password = 'project_email_pword';                          
			$mail->SMTPSecure = 'tls';       // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;          // TCP port to connect to
			$mail->setFrom('project_email', 'project_name');
			$mail->addAddress($email, $name);    

			$mail->SMTPOptions = array(
			  'ssl' => array(
			      'verify_peer' => false,
			      'verify_peer_name' => false,
			      'allow_self_signed' => true
			  )
			);
			$mail->isHTML(true);      // Set email format to HTML

			$mail->Subject = 'Welcome To project!';
			$mail->Body    = '<body>
			<div>
			<h4>Hello '.$name.',</h4>
			
			<br>Your registration was successful.

			<br>
			<br>Kind Regards,
			<br>
			<br>project_email Team.
			
			
			<br>
			<br>
			<b>(+234) 80 0000 0005
			</b>
			<br>
			</div>
			</body>';
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->send()) {
				return array('status' => 'success', 'log' => mysqli_error($this->conn), 'error'=>'Email error '.$mail->ErrorInfo );
			} else {
				return array('status' => 'success');
			}
			
		}
		
		
	}
?>