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
	
	require_once "header.php";
?>


  
  
<ul>
	<p> Sisse logitud: <?php echo $_SESSION["firstname"]." ".$_SESSION["lastname"]; ?>
	<li>Logi <a href="?logout=1">välja</li>
	<br>
	<li><a href="insert_data.php">Siit saad lisada uusi filme</a></li>
	<li><a href="filmid.php">Vaata lisatud filme</a></li>
	<li><a href="read_daycomments.php">Vaata lisatud päevakommentaare</a></li>
	<li><a href="gallery_photo_upload.php">Fotode galeriisse lisamine</a></li>
</ul>
<?php require_once "footer.php"; ?>
