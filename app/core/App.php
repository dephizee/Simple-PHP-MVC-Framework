<?php 
class App{
	protected $controller = "Home";
	protected $requirefile = '';
	protected $method = "index";
	protected $params = [];
	protected $all_controllers = [];

	function checkController(&$url_c){
		
		foreach ($this->all_controllers as $val) {
			$tmp = strtolower($val) ;
			$new_url = strtolower($url_c) . ".php";
			if ($tmp == $new_url) {
				$url_c = explode(".php", $val )[0];
				return true;
			}
		}
		return false;

	}

	function __construct(){
		$this->controller .'php';
		$urlp = 0;
		$url = $this->parseURL();
		if ($handle = opendir('app/controllers/')) {
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != "..") {
		            $this->all_controllers[] = $entry;
		        }
		    }
		    closedir($handle);
		}
		
		if(isset($url[$urlp]) && $this->checkController($url[$urlp] ) ){
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