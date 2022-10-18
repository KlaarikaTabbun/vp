<?php
	session_start();
	//loen sisse konfiguratsioonifailid

	require_once "fnc_user.php";
	if(!isset($_SESSION["user_id"])){
		//jõuga viiakse page.php
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
	
	require_once "../../config.php";
	$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
	//määrame suhtlemisel kasutatava kooditabeli
	$conn->set_charset("utf8");
	//valmistame ette SQL keeles päringu
	$stmt = $conn->prepare("SELECT comment, grade, added FROM vp_day_comment");
	echo $conn->error;
	//seome loetavad andmed muutujatega
	$stmt->bind_result($comment_from_db, $grade_from_db, $added_from_db);
	//täidame käsu
	$stmt->execute();
	echo $stmt->error;
	//võtan andmed
	//kui on oodata vaid üks võimalik kirje
	/*if($stmt->fetch()){
		//kõik mida teha
	};*/
	
	$comments_html = null;
	//kui on oodata mitut, aga teadamata arv
	while($stmt->fetch()) {
		//<p>Kommentaar, hinne päevale: x, lisatud yyyy.</p>
		$comments_html .= "<p>" .$comment_from_db .", hinne päevale: " .$grade_from_db .", lisatud " .$added_from_db .".</p> \n";
	}
	$stmt->close();
	//sulgeme andmebaasiühenduse
	$conn->close();
	
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Klaarika Tabbun, veebiprogrammeerimine</title>
</head>
<body>
<img src="pics/vp_banner_gs.png" alt="bänner">
   <h1>Klaarika Tabbun, veebiprogrammeerimine</h1>
   <p>See leht on loodud õppetöö raames ja ei sisalda tõsist infot!</p>
   <p>Õppetöö toimus <a href="https://www.tlu.ee">Tallinna Ülikoolis</a> Digitehnoloogiate instituudis.</p>
   <?php echo $comments_html; ?> 
</body>
</html>