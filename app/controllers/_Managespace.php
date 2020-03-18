<?php 
class _Managespace extends Controller{	
	function index(){
		$data = array('controller' => $this->getAllControllers(), 'view' => $this->getAllViews() );
		$this->view('_managespace', $data);
	}
	function add($action="",$name=""){
		$this->createNew($action, $name);
		header("Location: " . $_SERVER['HTTP_REFERER']);
	}
	function remove($action="",$name=""){
		$this->removeFile($action, $name);
		header("Location: " . $_SERVER['HTTP_REFERER']);
	}
	protected function removeFile($type, $name){

		$rfname = '';
		$name = preg_replace('/\s+/', '', $name);
		$cfiles = $this->{'getAll'.ucfirst($type).'s'}();
		foreach ($cfiles as $f) {
			if( strtolower($f) == strtolower($name) ){
				$rfname = $f;
			}
		}

		if($rfname == ''){
			$_SESSION['_managespace_log'] = $name ." ".$type." Not Found";
			return;
		}
		$name = $rfname;

		$filename = 'app/'.strtolower($type) .'s/'. 
				(strtolower($type)=='controller'?
				ucfirst($name):strtolower($name))

		.".php";
		if($type == 'controller'){
			unlink($filename);
			$_SESSION['_managespace_log'] = $name ." ".$type." Not Found";
			return;
		}
		$results = $this->checkUsage($name);
		if( count($results) == 0 ){
			unlink($filename);
			$_SESSION['_managespace_log'] = $name . " ". $type . " Removed  SuccessFully";
		}else{
			$log = "<h2>".$name . " ". $type . " was used in :</h2> ";
			foreach ($results as $kl1 => $vl1) {
				$log .= ', <h3>  controller '.$kl1.'</h3>';
				foreach ($vl1 as $kl2 => $vl2) {
					foreach ($vl2 as $vl3) {
						$log .= '<div> line : '.$kl2.' column : '.${vl3}.' </div>';
					}
					
				}
			}
			$_SESSION['_managespace_log'] = $log;
		}
		
	}
	protected function checkUsage($name){
		$results = array();
		$controllers = $this->getAllControllers();
		foreach ($controllers as $c) {
			$file_arr = file('app/controllers/'.$c.'.php');
			foreach ($file_arr as $k => $line) {
				$line= ' '.$line;
				$needle = '\''.$name.'\'';
				$pos = 0;
				while ($pos = strpos($line, $needle, $pos)) {
					$results[$c][$k+1][] = $pos;
					// print($pos ." line: ${k}<br>");
					strpos($line, $needle, ++$pos);
				}
				// print(strpos($line, $needle) ."   <<< ".$k."<br>");
				// print($line ."<br>");

			}
		}
		return $results;
	}
	protected function createNew($type, $name){
		$name = preg_replace('/\s+/', '', $name);
		$cfiles = $this->{'getAll'.ucfirst($type).'s'}();
		foreach ($cfiles as $f) {
			if( strtolower($f) == strtolower($name) ){
				$_SESSION['_managespace_log'] = $name ." ".$type." Already Exist";
				return;
			}
		}


		$file_arr = file('app/defaults/'.$type);
		$filename = 'app/'.strtolower($type) .'s/'. 
				(strtolower($type)=='controller'?
				ucfirst($name):strtolower($name))

		.".php";
		// var_dump($filename);die();
		foreach ($file_arr as $lines) {
			$lines = preg_replace('/fILEnAME/', ucfirst($name), $lines);
			file_put_contents($filename, $lines, FILE_APPEND | LOCK_EX);
		}
		$_SESSION['_managespace_log'] = $name . " ". $type . " Added  SuccessFully";
	}
	protected function getAllControllers(){
		$all_controllers = array();
		if ($handle = opendir('app/controllers/')) {
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != ".." && $entry != "_Managespace.php") {
		            $all_controllers[] = explode('.php', $entry)[0];
		        }
		    }
		    closedir($handle);
		}
		return $all_controllers;
	}
	protected function getAllViews(){
		$all_views = array();
		if ($handle = opendir('app/views/')) {
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != ".." && $entry != "_managespace.php") {
		            $all_views[] = explode('.php', $entry)[0];
		        }
		    }
		    closedir($handle);
		}
		return $all_views;
	}
}
 ?>