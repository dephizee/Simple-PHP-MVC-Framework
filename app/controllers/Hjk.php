<?php 
class Hjk extends Controller{
	//Default Method
	function index(){
		$data = array('name' => "Hjk", "next step" => "Add View" );
		// this can be used to render any available View along side the data to be rendered.
		// $this->view('view-name',  $data);


		// this can also be used to return json responses.
		header('Content-Type: application/json');
		print ( json_encode($data) );
	}	
}
 ?>