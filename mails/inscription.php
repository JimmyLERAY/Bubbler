<?php
$to = $email;
$subject = "Activation de votre compte sur Bubbler.fr";

$message = "
<html>
	<head>
		<title>".$subject."</title>
	</head>
	<body>
		<p>Votre compte Bubbler a bien été enregistré !</p>
		<p>Vous pouvez maintenant l'activer en copiant la clé suivante sur la page d'activation.</p>
		<p>Voici votre clé d'activation : <strong>".$token."</strong></p>
		<p>Si vous êtes perdu, voici un lien vers la <a href='http://bubbler.fr/#/activation'>page d'activation</a></p>
	</body>
</html>";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0"."\r\n";
$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
$headers .= 'From: <contact@bubbler.fr>'."\r\n";

mail($to,$subject,$message,$headers);