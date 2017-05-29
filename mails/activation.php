<?php
$to = $email;
$subject = "Bienvenue sur Bubbler.fr !";

$message = "
<html>
	<head>
		<title>".$subject."</title>
	</head>
	<body>
		<p>Votre compte Bubbler est activé, vous pouvez dès à présent vous connecter en utilisant vos identifiants.</p>
		<p>Revenez à la page pour vous connecter en cliquant sur <a href='http://bubbler.fr/#/connexion'>ce lien</a></p>
	</body>
</html>";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0"."\r\n";
$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
$headers .= 'From: <contact@bubbler.fr>'."\r\n";

mail($to,$subject,$message,$headers);