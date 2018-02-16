<?php 
/**
 * Class Wpopal_Image_Helper
 */
class Wpopal_Image_Helper{

	/**
	 *
	 */
	public static function createImageSize( $source, $attr ){
		
		$attr = explode( 'x', $attr );
		$arg = array();
		if( !empty( $attr[2] ) ){
			$arg['w'] = $attr[0];
			$arg['h'] = $attr[1];
			$arg['a'] = $attr[2];
			if( $attr[2] != 'c' ){
				$arg['a'] = $attr[2];
				$attr = '-'.implode('x',$attr);
			}else{
				$attr = '-'.$attr[0].'x'.$attr[1].'xc';
			}
			
		}else if( !empty( $attr[0] ) && !empty( $attr[1] ) ){
			$arg['w'] = $attr[0];
			$arg['h'] = $attr[1];
			$attr = '-'.$attr[0].'x'.$attr[1].'xc';
		}else{
			return $source;
		}
		
		$source = strrev( $source );
		$st = strpos( $source, '.');
		
		if( strpos( $source, strrev( 'images/default.jpg' ) ) === 0 ){
			return strrev( $source );
		}else if( $st === false ){
			return strrev( $source ).$attr;
		}else{
			
			$file = str_replace( array( untrailingslashit( site_url() ).'/', '\\', '/' ), array( ABSPATH, KCAS, KCAS ), strrev( $source ) );
			
			$_return = strrev( substr( $source, 0, $st+1 ).strrev($attr).substr( $source, $st+1 ) );
			$__return = str_replace( array( untrailingslashit( site_url() ).'/', '\\', '/' ), array( ABSPATH, KCAS, KCAS ), $_return );
	
			if( file_exists( $file ) && !file_exists( $__return ) ){
				ob_start();
				self::processImage( $file, $arg, $__return );
				ob_end_clean();
			}
			
			return $_return;
			
		}
	}
	
	/**
	 *
	 */
	public static function processImage( $localImage, $params = array(), $tempfile ){

		$sData = getimagesize($localImage);
		$origType = $sData[2];
		$mimeType = $sData['mime'];

		if(! preg_match('/^image\/(?:gif|jpg|jpeg|png)$/i', $mimeType)){
			return "The image being resized is not a valid gif, jpg or png.";
		}

		if (!function_exists ('imagecreatetruecolor')) {
		    return 'GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library';
		}

		if (function_exists ('imagefilter') && defined ('IMG_FILTER_NEGATE')) {
			$imageFilters = array (
				1 => array (IMG_FILTER_NEGATE, 0),
				2 => array (IMG_FILTER_GRAYSCALE, 0),
				3 => array (IMG_FILTER_BRIGHTNESS, 1),
				4 => array (IMG_FILTER_CONTRAST, 1),
				5 => array (IMG_FILTER_COLORIZE, 4),
				6 => array (IMG_FILTER_EDGEDETECT, 0),
				7 => array (IMG_FILTER_EMBOSS, 0),
				8 => array (IMG_FILTER_GAUSSIAN_BLUR, 0),
				9 => array (IMG_FILTER_SELECTIVE_BLUR, 0),
				10 => array (IMG_FILTER_MEAN_REMOVAL, 0),
				11 => array (IMG_FILTER_SMOOTH, 0),
			);
		}

		// get standard input properties
		$new_width =  (int) abs ($params['w']);
		$new_height = (int) abs ($params['h']);
		$zoom_crop = !empty( $params['zc'] )?(int) $params['zc']:1;
		$quality =  !empty( $params['q'] )?(int) $params['q']:100;
		$align = !empty( $params['a'] )? $params['a']: 'c';
		$filters = !empty( $params['f'] )? $params['f']: '';
		$sharpen = !empty( $params['s'] )? (bool)$params['s']: 0;
		$canvas_color = !empty( $params['cc'] )? $params['cc']: 'ffffff';
		$canvas_trans = !empty( $params['ct'] )? (bool)$params['ct']: 1;

		// set default width and height if neither are set already
		if ($new_width == 0 && $new_height == 0) {
		    $new_width = 100;
		    $new_height = 100;
		}

		// ensure size limits can not be abused
		$new_width = min ($new_width, 1500);
		$new_height = min ($new_height, 1500);

		// set memory limit to be able to have enough space to resize larger images
		ini_set('memory_limit', '300M');

		// open the existing image
		switch ($mimeType) {
			case 'image/jpeg':
				$image = imagecreatefromjpeg ($localImage);
				break;

			case 'image/png':
				$image = imagecreatefrompng ($localImage);
				break;

			case 'image/gif':
				$image = imagecreatefromgif ($localImage);
				break;

			default: $image = false; break;

		}

		if ($image === false) {
			return 'Unable to open image.';
		}

		// Get original width and height
		$width = imagesx ($image);
		$height = imagesy ($image);
		$origin_x = 0;
		$origin_y = 0;

		// generate new w/h if not provided
		if ($new_width && !$new_height) {
			$new_height = floor ($height * ($new_width / $width));
		} else if ($new_height && !$new_width) {
			$new_width = floor ($width * ($new_height / $height));
		}

		// scale down and add borders
		if ($zoom_crop == 3) {

			$final_height = $height * ($new_width / $width);

			if ($final_height > $new_height) {
				$new_width = $width * ($new_height / $height);
			} else {
				$new_height = $final_height;
			}

		}

		// create a new true color image
		$canvas = imagecreatetruecolor ($new_width, $new_height);
		imagealphablending ($canvas, false);

		if (strlen($canvas_color) == 3) { //if is 3-char notation, edit string into 6-char notation
			$canvas_color =  str_repeat(substr($canvas_color, 0, 1), 2) . str_repeat(substr($canvas_color, 1, 1), 2) . str_repeat(substr($canvas_color, 2, 1), 2);
		} else if (strlen($canvas_color) != 6) {
			$canvas_color = 'ffffff'; // on error return default canvas color
 		}

		$canvas_color_R = hexdec (substr ($canvas_color, 0, 2));
		$canvas_color_G = hexdec (substr ($canvas_color, 2, 2));
		$canvas_color_B = hexdec (substr ($canvas_color, 4, 2));

		// Create a new transparent color for image
	    // If is a png and PNG_IS_TRANSPARENT is false then remove the alpha transparency
		// (and if is set a canvas color show it in the background)
		if(preg_match('/^image\/png$/i', $mimeType) && $canvas_trans){
			$color = imagecolorallocatealpha ($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 127);
		}else{
			$color = imagecolorallocatealpha ($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 0);
		}


		// Completely fill the background of the new image with allocated color.
		imagefill ($canvas, 0, 0, $color);

		// scale down and add borders
		if ($zoom_crop == 2) {

			$final_height = $height * ($new_width / $width);

			if ($final_height > $new_height) {

				$origin_x = $new_width / 2;
				$new_width = $width * ($new_height / $height);
				$origin_x = round ($origin_x - ($new_width / 2));

			} else {

				$origin_y = $new_height / 2;
				$new_height = $final_height;
				$origin_y = round ($origin_y - ($new_height / 2));

			}

		}

		// Restore transparency blending
		imagesavealpha ($canvas, true);

		if ($zoom_crop > 0) {

			$src_x = $src_y = 0;
			$src_w = $width;
			$src_h = $height;

			$cmp_x = $width / $new_width;
			$cmp_y = $height / $new_height;

			// calculate x or y coordinate and width or height of source
			if ($cmp_x > $cmp_y) {

				$src_w = round ($width / $cmp_x * $cmp_y);
				$src_x = round (($width - ($width / $cmp_x * $cmp_y)) / 2);

			} else if ($cmp_y > $cmp_x) {

				$src_h = round ($height / $cmp_y * $cmp_x);
				$src_y = round (($height - ($height / $cmp_y * $cmp_x)) / 2);

			}

			// positional cropping!
			if ($align) {
				if (strpos ($align, 't') !== false) {
					$src_y = 0;
				}
				if (strpos ($align, 'b') !== false) {
					$src_y = $height - $src_h;
				}
				if (strpos ($align, 'l') !== false) {
					$src_x = 0;
				}
				if (strpos ($align, 'r') !== false) {
					$src_x = $width - $src_w;
				}
			}

			imagecopyresampled ($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);

		}
		else {

			// copy and resize part of an image with resampling
			imagecopyresampled ($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		}

		//Straight from Wordpress core code. Reduces filesize by up to 70% for PNG's
		if ( (IMAGETYPE_PNG == $origType || IMAGETYPE_GIF == $origType) && function_exists('imageistruecolor') && !imageistruecolor( $image ) && imagecolortransparent( $image ) > 0 ){
			imagetruecolortopalette( $canvas, false, imagecolorstotal( $image ) );
		}

		$imgType = "";
		
		if(preg_match('/^image\/(?:jpg|jpeg)$/i', $mimeType)){
			$imgType = 'jpg';
			imagejpeg($canvas, $tempfile, 100);
		} else if(preg_match('/^image\/png$/i', $mimeType)){
			$imgType = 'png';
			imagepng($canvas, $tempfile, 0);
		} else if(preg_match('/^image\/gif$/i', $mimeType)){
			$imgType = 'gif';
			imagegif($canvas, $tempfile);
		} else {
			return "Could not match mime type after verifying it previously.";
		}

		@imagedestroy($canvas);
		@imagedestroy($image);

	}

	/**
	 *
	 */
	public static function hex2rgb( $hex, $index = 0 ) {

	   $hex = str_replace("#", "", $hex);

	   if( strpos( $hex, 'rgb' ) !== false ){
	   	  $hex = explode( ',', $hex );
	   	  $r = preg_replace("/[^0-9,.]/", "", $hex[0]);
	   	  $g = preg_replace("/[^0-9,.]/", "", $hex[1]);
	   	  $b = preg_replace("/[^0-9,.]/", "", $hex[2]);
	   }else if( strlen( $hex ) == 3 ) {
	      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
	      $r = hexdec(substr($hex,0,2));
	      $g = hexdec(substr($hex,2,2));
	      $b = hexdec(substr($hex,4,2));
	   }

	   $r = ($r-$index>0)?$r-$index:0;
	   $g = ($g-$index>0)?$g-$index:0;
	   $b = ($b-$index>0)?$b-$index:0;

	   return "$r, $g, $b";

	}

}	