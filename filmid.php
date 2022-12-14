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
	
	$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
//määrame suhtlemisel kasutatava kooditabeli
$conn->set_charset("utf8");
//valmistame ette SQL keeles päringu
$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, zanr, tootja, lavastaja FROM film");
echo $conn->error;
//seome loetavad andmed muutujatega
$stmt->bind_result($title, $year, $duration, $genre, $studio, $director);
//täidame käsu
$stmt->execute();
echo $stmt->error;

$film_html = null;
while($stmt->fetch()){
	$film_html .= "<h3>" .$title ."</h3>"
  ."<ul>"
  ."<li>Valmimisaasta:" .$year ."</li>"
    ."<li>Kestus:" .$duration ."</li>"
  ."<li>Žanr:" .$genre ."</li>"
    ."<li>Tootja:" .$studio ."</li>"
    ."<li>Lavastaja:" .$director ."</li>"
  ."</ul>";
}
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