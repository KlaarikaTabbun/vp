<?php

//loen sisse config faili
require_once "../config.php";
//echo $server_host;
    $author_name = "Klaarika Tabbun";
    //echo $author_name;
	
	//loome andmebaasi ühenduse
			$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
			//määrame suhtlemisel kasutatava kooditabeli
			$conn->set_charset("utf8");
			//valmistame ette sql keeles päringu
			$stmt = $conn->prepare("INSERT INTO film (PEALKIRI, AASTA, KESTUS, ZANR, TOOTJA, LAVASTAJA) VALUES");
			echo $conn->error;

$title_error = null;
$year_error = null;
$duration_error = null;
$genre_error = null;
$studio_error = null;
$director_error = null;

if(isset($_POST["film_submit"])){
  if(isset($_POST["title_input"]) and !empty($_POST["title_input"])){
   } $title = $_POST["title_input"];
  } else {
    $title_error = "Pealkiri jäi lisamata!";
  }
  if(isset($_POST["year_input"]) and !empty($_POST["year_input"])){
    $year = $_POST["year_input"];
  } else {
    $year_error = "Aasta jäi lisamata!";
  }
  if(isset($_POST["duration_input"]) and !empty($_POST["duration_input"])){
    $duration = $_POST["duration_input"];
  } else {
    $duration_error = "Kestus jäi lisamata!";
  }
  if(isset($_POST["genre_input"]) and !empty($_POST["genre_input"])){
    $genre = $_POST["genre_input"];
  } else {
    $genre_error = "Žanr jäi lisamata!";
  }
  if(isset($_POST["studio_input"]) and !empty($_POST["studio_input"])){
    $studio = $_POST["studio_input"];
  } else {
    $studio_error = "Tootja jäi lisamata!";
  }
  if(isset($_POST["director_input"]) and !empty($_POST["director_input"])){
    $director = $_POST["director_input"];
  } else {
    $director_error = "Režissöör jäi lisamata!";
  }
if(empty($title_error and $year_error and $duration_error and $genre_error and $studio_error and $director_error))

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
  
  
  <form method="POST">
        <label for="title_input">Filmi pealkiri</label>
        <input type="text" name="title_input" id="title_input" placeholder="filmi pealkiri">
        <br>
        <label for="year_input">Valmimisaasta</label>
        <input type="number" name="year_input" id="year_input" min="1912">
        <br>
        <label for="duration_input">Kestus</label>
        <input type="number" name="duration_input" id="duration_input" min="1" value="60" max="600">
        <br>
        <label for="genre_input">Filmi žanr</label>
        <input type="text" name="genre_input" id="genre_input" placeholder="žanr">
        <br>
        <label for="studio_input">Filmi tootja</label>
        <input type="text" name="studio_input" id="studio_input" placeholder="filmi tootja">
        <br>
        <label for="director_input">Filmi režissöör</label>
        <input type="text" name="director_input" id="director_input" placeholder="filmi režissöör">
        <br>
        <input type="submit" name="film_submit" value="Salvesta">
    </form>
	
  
</body>
</html>