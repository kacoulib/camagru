<?php

	require_once('TraitValidator.php');
	require_once('TraitDbQuery.php');

	class Image
	{
		public	$id;
		public	$user_id;
		private	$nb_like = 0;
		public	$name;
		public	$description;
		public	$url;

		use Validator;
		use DbQuery;

		function __construct()
		{
			try
			{
				$db = new Connect();
				$this->db = $db->get();
			}
			catch (Exception $e)
			{
				return (false);
			}

			return ($this);
		}

		private function rules()
		{
			return ([
				'id'		=> 'numeric',
				'name'		=> 'required|max:255|min:3',
				'name'		=> 'max:255',
				'user_id'	=> 'required|numeric|max:3',
				'url'		=> 'required'
			]);
		}

		public function merge_jpeg_and_png($dst_name, $src_img)
		{
			// /* Create copy of the dest 

			// 	$dst = file_exist($dst_name)*/
			if (file_exists($src_img))
			{
				$dest_size = getimagesize($src_img);
				var_dump(imagecreatefrompng());


			// // copying relevant section from watermark to the cut resource 
			// imagecopy($cut, $src_img, 0, 0, $src_x, $src_y, $src_w, $src_h); 

			// // insert cut resource to destination image 
			// imagecopymerge($dst_img, $cut, , 100, 100, 0, 0, 256, 256, 100);

			// /* Generate an url
			 	
			//  	$url = ... */
				try
				{
					$sql = $this->db->prepare('SELECT MAX(id) FROM Images');
					$sql->execute();
					$id = $sql->fetchColumn();
					echo $id;
				}
				catch(Exception $e)
				{
					echo 'Exception reçue : ',  $e->getMessage(), "\n";
					exit;
				}
				echo "----";

				/// old

				// if (file_exists($src))
				// {
				// 	$dest = str_replace('data:image/png;base64,', '', $_POST['img']);
				// 	$dest = str_replace(' ', '+', $dest);
				// 	$dest = base64_decode($dest);
				// 	file_put_contents('test.png', $dest);
				// 	return ;
				// 	if (!($dest = @imagecreatefromstring($dest)) || !($src = @imagecreatefrompng($src)))
				// 		exit;
				// 	imageAlphaBlending($src, true);
				// 	imageSaveAlpha($src, true);

				// 	imagecopymerge($dest, $src, 100, 100, 0, 0, 256, 256, 100);
					
				// 	imagepng($dest, '../Public/img/gun0.png');
				// 	imagedestroy($dest);
				// 	imagedestroy($src);
				// }
				return (true);
			}

			/* save with the new url */
			// imagejpeg($dest_ing, $url);
			return ($new_img_name);
		}

		public function like($img_id)
		{
			if (is_numeric($img_id))
				return ($this->error('unknow image'));

			$this->nb_like++;

			return ($this);
		}

		//	[
		//		'title' => 'required|unique:posts|max:255',
		//		'body' => 'required',
		//	]

	}