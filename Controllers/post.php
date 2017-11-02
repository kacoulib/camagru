<?php 

	if (isset($_POST) && !empty($_POST['data']))
	{
		$im = imagecreatefrompng($_POST['data']);

		header('Content-Type: image/png');

		imagepng($im, 'test.png');
		// imagedestroy($im);
	}