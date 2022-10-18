<?php

//loen sisse config faili
//require_once "../config.php";
//echo $server_host;
//algatan sessiooni
	session_start();
	//loen sisse konfiguratsioonifaili
	require_once "fnc_user.php";
	//echo $server_user_name;
	
    $author_name = "Klaarika Tabbun";
    //echo $author_name;
	$full_time_now = date("d.m.Y H:i:s");
	$weekday_names_et = ["esmaspäev","teisipäev","kolmapäev","neljapäev","reede", "laupäev","pühapäev"];
	//echo $weekday_names_et[2];
	$weekday_now = date("N"); 
	$hour_now=date("H");
	$part_of_day = "suvaline hetk";
	
	//  ==on võrdne!= pole võrdne <  > <= >=
	//argipäev
    //if ($weekday_now <==5){

	if($hour_now < 7 ){
		$part_of_day="uneaeg";
	}
	//and or
	
	if($hour_now >= 8 and $hour_now <18) {
		$part_of_day="koolipäev";
	}
	if($hour_now >= 18 and $hour_now <19) {
		$part_of_day="kojumineku aeg";
		}
	if($hour_now >= 19 and $hour_now <20) {
		$part_of_day="õhtusöögi aeg";
		}
	if($hour_now >=20  and $hour_now <23) {
		$part_of_day="puhkamise aeg";
		}
	if($hour_now >= 23 and $hour_now <7) {
		$part_of_day="uneaeg";
		}
	//}
	//nädalavahetus
	//if ($weekday_now==6){}
	//if ($weekday_now==7){}
		
	
		
	$folklore=array ("Väikesed lapsed, väikesed mured, suured lapsed, suured mured.","Targaks ei sünnita, targaks õpitakse.","Mida Juku ei õpi, seda Juhan ei tea.","Kelle jalg tatsub, selle suu matsub.","Hea sõna võidab võõra väe.");
	
	//vaatame semestri pikkust ja kulgemist
	$semester_begin= new DateTime("2022-09-05");
	$semester_end = new DateTime ("2022-12-18");
	$semester_duration = $semester_begin->diff($semester_end);
	$semester_duration_days= $semester_duration->format("%r%a");
	//echo $semester_duration_days;
	$from_semester_begin = $semester_begin->diff(new DateTime("now"));
	$from_semester_begin_days = $from_semester_begin->format("%r%a");
	//loendan massiivi (array) liimeid
	//echo count($weekday_names_et);
	//juhuslik arv 
	//echo mt_rand(1, 9);
	//juhuslik elemest massiivivst
	//echo $weekday_names_et[mt_rand(0, count($weekday_names_et) - 1)];
	
	//loeme fotode kataloogi sisu
	
	$photo_dir = "photos/";
	//$all_files = scandir($photo_dir);
	//uus_massiiv=array_slice(massiiv,mis kohast alates);
	$all_files = array_slice(scandir($photo_dir),2);
	//var_dump($all_files);
	
	//<img src = "kataloog/fail" alt = "tekst">
	$photo_html = null;
	
	//tsükkel
	//muutuja väärtuse suurendamine:$muutuja = $muutuja +5
	//$muutuja +=5
	//kui suureneb 1 võrra $muutuja ++
	//on ka -= ja --
	/*for($i = 0; $i < count($all_files); $i ++){
		echo $all_files[$i] ." ";
	}*/
	
	/*foreach($all_files as $file_name){
		echo $file_name ." | ";
	}*/
	
	//loetlen lubatud failitüübid (jpg  png )
	//MIME
	$allowed_photo_types = ["image/jpeg", "image/png"];
	$photo_files = [];
	foreach($all_files as $file_name){
		$file_info = getimagesize($photo_dir .$file_name);
		if(isset($file_info["mime"])){
			if(in_array($file_info["mime"], $allowed_photo_types)){
				array_push($photo_files, $file_name);
			}
		}
	}
	
	$photo_number = mt_rand(0, count($photo_files) - 1);
	
	//var_dump($photo_files);
	$photo_html = '<img src = "' .$photo_dir .$photo_files[mt_rand(0, count($photo_files)-1)].'" alt="Tallinna pilt">';
	
	//vormi info kasutamine
	//$_POST
	$adjective_html = null;
	if(isset($_POST["todays_adjective_input"]) and !empty($_POST["todays_adjective_input"])){
	$adjective_html = "<p>Tänase kohta on arvatud: " .$_POST["todays_adjective_input"] .".</p>"; 
	}
	
	//kasutaja foto
	
	if(isset($_POST["photo_select"]) and $_POST["photo_select"] >= 0){
		$photo_number = $_POST["photo_select"];
	}
	
	$select_html = '<option value="" selected disabled>Vali pilt</option>';
	for($i = 0; $i < count($photo_files); $i ++){
		$select_html .= '<option value="' .$i .'"';
		if($i == $photo_number){
			$select_html .= " selected";
		}
		$select_html .= ">";
		$select_html .= $photo_files[$i];
		$select_html .= "</option> \n";
	}
	$photo_html = '<img src="' .$photo_dir .$photo_files[$photo_number] .'" alt="Tallinna pilt">';
	
	//teen fotode rippmenüü
	//<option value ="0">tln_1.JPG</option>
	// <option value ="1">tln_111.JPG</option>
	$select_html = '<option value ="" selected disabled>Vali pilt</option>';
	for($i = 0; $i < count($all_files); $i ++){
		$select_html .='<option value="' .$i .'">';
		$select_html .=$photo_files[$i];
		$select_html .="</option> \n";
	}
	
	if(isset($_POST["photo_select"]) and $_POST["photo_select"] >= 0){
     
	}	
$comment_error = null;
//tegeleme päevale antud hinde ja kommentaariga
	if(isset($_POST["comment_submit"])){
		if(isset($_POST["comment input"]) and !empty($_POST["comment input"])){
		$comment = $_POST["comment_input"];
		} else {
			$comment_error= "Kommentaar jäi lisamata!";
		}
		$grade = $_POST["grade_input"];
		
		if(empty($comment_error)){
		
			//loome andmebaasi ühenduse
			$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
			//määrame suhtlemisel kasutatava kooditabeli
			$conn->set_charset("utf8");
			//valmistame ette sql keeles päringu
			$stmt = $conn->prepare("INSERT INTO vp_daycomment (COMMENT, GRADE) VALUES(?,?)");
			echo $conn->error;
			//seome sql päringu päris andmetega
//määrame andmetüübid: i- integer(täisarv), d-decimal(murdarv), s-string(tekst)			
			$stmt->bind_param("si", $comment, $grade);
			//täidame käsu
			$stmt->execute();
			echo $stmt->error;
			//sulgeme käsu
			$stmt->close();
			//sulgeme andmebaasi ühenduse
			$conn->close();
		}
	}
	
	$login_error = null;
	if(isset($_POST["login_submit"])){
        $login_error = sign_in($_POST["email_input"], $_POST["password_input"]);
    }

	
	
	?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title><?php echo $author_name;?>, veebiprogrammeerimine</title>
</head>
<body>
<img src="pics/vp_banner_gs.png" alt="bänner">
   <h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
   <p>See leht on loodud õppetöö raames ja ei sisalda tõsist infot!</p>
   <p>Õppetöö toimus <a href="https://www.tlu.ee">Tallinna Ülikoolis Digitehnoloogiate instituudis</a>.</p>
      <!--kasutaja sisselogimine-->
<hr>
	<h2>Logi sisse</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input type="email" name="email_input" placeholder="Kasutajatunnus ehk e-post">
		<input type="password" name="password_input" placeholder="salasõna">
		<input type="submit" name="login_submit" value="Logi sisse"><span><strong><?php echo $login_error; ?></strong></span>
	</form>
	<p><a href="add_user.php">Loo omale kasutaja</a></p>
	<hr>
   
   
   <p>Lehe avamise hetk: <?php echo $weekday_names_et[$weekday_now-1]. ",". $full_time_now; ?>.</p>
   <p>Praegu on <?php echo $part_of_day; ?> </p>
   <p>Semester edeneb:<?php echo $from_semester_begin_days ."/". $semester_duration_days; ?></p>
   <img src="pics/tlu_38.jpg" alt="Tallinna Ülikooli Astra Õppehoone">

   <!--päeva kommentaaride lisamine-->
   
   <form method="POST">
		<lable for="comment_input">Kommentaar tänase päeva kohta:</lable>
		<br>
		<textarea id="comment_input" name="comment_input" cols="70" rows="2" placeholder="kommentaar"></textarea>
		<br>
		<lable for = "grade_input">Hinne tänasele päevale (0 ... 10):</lable>
		<input type="number" id="grade_input" name="grade_input" min="0" max="10" step="1" value="5">
		<br>
		<input type="submit" id="comment_submit" name="comment_submit" value="Salvesta">
   </form>
   <p>Vanasõna:  <?php echo $folklore[array_rand($folklore)]; ?>  </p>
   <!--kommentaar-->
   <form method="POST">
    <input type = "text" id="todays_adjective_input" name="todays_adjective_input" placeholder="Omadussõna tänase kohta">
	<input type="submit" id="todays_adjective_submit" name="todays_adjective_submit" value="Saada omadussõna">
   </form>
   <?php echo $adjective_html; ?>
   <form method = "POST">
   <select id ="photo_select" name ="photo_select">
    <?php echo $select_html; ?>
   </select>
   <input type = "submit" id = "photo_submit" name = "photo_submit" value = "OK">
   <span><?php echo $comment_error; ?>
   </form>
   <?php echo $photo_html; ?>
</body>
</html>