<?php 
class App{
	protected $controller = "Home";
	protected $method = "index";
	protected $params = [];

	function __construct(){
		$urlp = 0;
		$url = $this->parseURL();
		
		if(isset($url[$urlp]) && file_exists('app/controllers/'. $url[$urlp].'.php')){
			$this->controller = $url[$urlp++];
		}
		require('app/controllers/'. $this->controller.'.php');
		$this->controller = new $this->controller;
		if(isset($url[$urlp]) && method_exists($this->controller, $url[$urlp]) ){
			$this->method = $url[$urlp++];
		}
		if(is_array($url)){
			for ($i=$urlp; $i < count($url); $i++) { 
				$this->params[$i] = $url[$urlp++];
			}
		}
		
		// var_dump($this->params);
		// call_user_method_array($this->controller, $this->method, $this->params);
		call_user_func_array ([ $this->controller, $this->method], $this->params);


	}

	function parseURL(){	
		if( isset($_GET['url']) ){
			$url = $_GET['url'];
			$url = rtrim($url,'/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/',$url);
			return $url;
		}
		if( isset($_POST) ){
			// $url = $_POST['url'];
			// var_dump( $_POST);
			// $url = rtrim($url,'/');
			// $url = filter_var($url, FILTER_SANITIZE_URL);
			// $url = explode('/',$url);
			return [];
		}

	}
}
 ?>