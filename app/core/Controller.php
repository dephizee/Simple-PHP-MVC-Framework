<?php 
class Controller{
	
	function __construct()
	{
		# code...
	}

	protected function view($view, $data){
		
		if(file_exists('app/views/'.$view.'.php') ){
			require_once 'app/core/view-config.php';
			print('<base href="'.$baseUrl.'">');
			require_once 'app/views/'.$view.'.php';
		}else{
			echo "<h1><i>" . $view. "</i> View Not found</h1>";
		}
		
	}
}
 ?>