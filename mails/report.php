<?php
$to = 'jimmy_leray@hotmail.fr';
$subject = "Rapport de bug sur Bubbler.fr !";

$message = "
<html>
	<head>
		<title>".$subject."</title>
	</head>
	<body>
		<h1>Rapport de bug anonyme :</h1>
		<p>".$report."</p>
	</body>
</html>";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0"."\r\n";
$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
$headers .= 'From: <contact@bubbler.fr>'."\r\n";

mail($to,$subject,$message,$headers);