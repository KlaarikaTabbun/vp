<?php
require_once "../config.php";
	
	//loome andmebaasi ühenduse
			$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
	//määrame suhtlemisel kasutatava kooditabeli
			$conn->set_charset("utf8");
	//valmistame ette sql keeles päringu
			$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, zanr, tootja, lavastaja FROM film");
			echo $conn->error;
			
			//seome loetavad andmed muutujatega
			$stmt->bind_result($title_from_db, $year_from_db, $duration_from_db, $genre_from_db, $production_from_db, $producer_from_db);
			//täidame käsu
			$stmt->execute();
			echo $stmt->error;
			//võtan andmeid
			
			$film_html=null;
			//kui on oodata mitut kuid teadmata arv
			while($stmt->fetch()){
				
		$film_html .= "<p>" .$title_from_db .". aasta " .$year_from_db .".  kestus " .$duration_from_db .". zanr ". $genre_from_db.". tootja " .$production_from_db.". lavastaja " .$producer_from_db .".</p> \n";
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
 
 <?php echo $film_html; ?> 
</body>
</html>