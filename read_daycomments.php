<?php
	require_once "../config.php";
	
	//loome andmebaasi ühenduse
			$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
	//määrame suhtlemisel kasutatava kooditabeli
			$conn->set_charset("utf8");
	//valmistame ette sql keeles päringu
			$stmt = $conn->prepare("SELECT comment, grade, added FROM vp_daycomment");
			echo $conn->error;
			//seome loetavad andmed muutujatega
			$stmt->bind_result($comment_from_db, $grade_from_db, $added_from_db);
			//täidame käsu
			$stmt->execute();
			echo $stmt->error;
			//võtan andmeid
			//kui on oodata vaid üks võimalik kirje
			//if($stmt->fetch(){
				//kõik mida teha
			//}
			$comments_html=null;
			//kui on oodata mitut kuid teadmata arv
			while($stmt->fetch()){
				// <p>kommentaar, hinne päevale:x , lisatud yyyyyy.</p>
		$comments_html .= "<p>" .$comment_from_db .". Hinne päevale: " .$grade_from_db .".  Lisatud " .$added_from_db .".</p> \n";
			}
			//sulgeme käsu
			$stmt->close();
			//sulgeme andmebaasi ühenduse
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