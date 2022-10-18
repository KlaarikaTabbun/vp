<?php
	session_start();
	if(!isset($_SESSION["user_id"])){
		//jõuga viiakse page.php lehele
		header("Location: page.php");
		exit();
	}
	
	//logime välja
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
		exit();
	}
	
	require_once "fnc_photo_upload.php";
	
	//kontrollin pildi valikut
	$file_type=null;
	$photo_error=null;
	$photo_file_size_limit = 1.5 * 1024 * 1024;
	$photo_name_prefix = "vp_";
	$file_name = null;
	$normal_photo_max_w = 800;
	$normal_photo_max_h = 450;
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST["photo_submit"])){
			//var_dump($_POST);
			var_dump($_FILES["photo_input"]);
			//kas on üldse pildi fail ja mis tüüpi
			if(isset($_FILES["photo_input"]["tmp_name"]) and!empty($_FILES["photo_input"]["tmp_name"])){
				$file_type = check_file_type ($_FILES["photo_input"]["tmp_name"]);
				if($file_type == 0){
					$photo_error = "Valitud fail pole sobivat tüüpi!";
				}
			}	else{
				$photo_error = "Pildifail on valimata!";
			}
			//faili suurus
			if(empty ($photo_error)){
				if($_FILES["photo_input"]["tmp_name"] > $photo_file_size_limit){
					$photo_error = "Valitud fail on liiga suur!";
				}
			}
			
			if(empty($photo_error)){
				//loon uue faili nime
				$file_name = create_filename($photo_name_prefix, $file_type);
			
			//teen (väiksema) normaalmõõdus pildi
			//loome pixli kogumi ehk image objekti
			$temp_photo = create_image($_FILES["photo_input"]["tmp_name"],$file_type);
			//teeme väiksemaks
			$normal_photo = resize_photo($temp_photo, $normal_photo_max_w, $normal_photo_max_h);
			//salvesta väiksemaks tehtud pilt
			save_photo($normal_photo, "photo_upload_normal/" .$file_name, $file_type);
			
			//tõstan ajutise pildi fali oma soovitud kohta
			//move_uploaded_file($_FILES["photo_input"]["tmp_name"], "photo_upload_original/" .$_FILES["photo_input"]["name"]);
			move_uploaded_file($_FILES["photo_input"]["tmp_name"], "photo_upload_original/" .$file_name);
			}//if empty error
		}//if photo submit
	}//if post
	
	require_once "header.php";
?>


  
<ul>
	<p> Sisse logitud: <?php echo $_SESSION["firstname"]." ".$_SESSION["lastname"]; ?>
	<li>Logi <a href="?logout=1">välja</li>
	<br>
	<li><a href="insert_data.php">Siit saad lisada uusi filme</a></li>
	<li><a href="filmid.php">Vaata lisatud filme</a></li>
	<li><a href="read_daycomments.php">Vaata lisatud päevakommentaare</a></li>
	<li><a href="gallery_photo_upload.php">Tagasi avalehele</a></li>
	<hr>
	<h2>Fotode galeriisse lisamine</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		<label for="photo_input">Vali pildifail: </label>
		<input type="file" name="photo_input" id="photo_input">
		<br>
		<label for="alt_input">Alternatiivtekst (alt): </label>
		<input type="text" name="alt_input" id="alt_input" placeholder="alternatiivtekst...">
		<br>
		<input type="radio" name="privacy_input" id="privacy_input_1" value="1"
		<label for="privacy_input_1">Privaatne (ainult ise näen)</label>
		<br>
		<input type="radio" name="privacy_input" id="privacy_input_2" value="2"
		<label for="privacy_input_2">Sisseloginud kasutajale</label>
		<br>
		<input type="radio" name="privacy_input" id="privacy_input_3" value="3"
		<label for="privacy_input_3">Avalik</label>
		<br>
		<input type="submit" name="photo_submit" id="photo_submit" value="Lae üles">
		<span><?php echo $photo_error; ?></span>
	</form>
</ul>
<?php require_once "footer.php"; ?>
