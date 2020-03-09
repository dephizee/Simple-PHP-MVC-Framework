<?php 
	
	class ImageProcessor{

		public static function upload_image($files, &$file_loc){
			$r = rand(0, 1000);
			if(!file_exists($file_loc)){
				mkdir($file_loc);
			}
			$thumbnail_file_loc = $file_loc.'thumbnail/';
			if(!file_exists($thumbnail_file_loc)){
				mkdir($thumbnail_file_loc);
			}

			$thumbnail_file_loc .= $r.$files['pic']['name'];

			$file_loc .= $r.$files['pic']['name'];
			

			move_uploaded_file($files['pic']['tmp_name'], $file_loc);

			
			$type = $files['pic']['type'];
			ImageProcessor::genThumbnail($file_loc, $thumbnail_file_loc, $type);
			$image_data = array();
			$image_data['original'] = $file_loc;
			$image_data['thumbnail'] = $thumbnail_file_loc;
			return $image_data;
		}
		public static function genThumbnail($src, $loc, $type){
			if($type =='image/jpeg'){
				$data = imagecreatefromjpeg($src);
			}elseif($type =='image/png'){
				$data = imagecreatefrompng($src);
			}
			
			//
			$width = imagesx($data);
			$height = imagesy($data);
			$desired_height = 200;
			$desired_width = 200;

			$desired_height = floor($height * ($desired_width/ $width));
			$new_data = imagecreatetruecolor($desired_width, 200);
			$offsety = ($height - $width)/2;
			$offsetx = ($width - $height)/2;
			if($height>$width){
				imagecopyresampled($new_data, $data, 0, 0, 0, $offsety, $desired_width, 200, $width, $offsety+$width);
			}else{
				imagecopyresampled($new_data, $data, 0, 0, $offsetx, 0, 200, 200, $height+$offsetx, $height);
			}
			
			//imagecopyresampled(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
			imagejpeg($new_data, $loc);
		}
		
		
	}
	

	

 ?>