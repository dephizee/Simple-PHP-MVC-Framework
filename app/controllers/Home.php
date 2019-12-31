<?php 
class Home extends Controller{
	
	function index(){
		$this->view('home', [1,'aa']);
	}	
}
 ?>