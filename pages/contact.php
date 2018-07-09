<?php
session_start();
include('../includes/header.inc.php');
include('../includes/nav.inc.php');
?>
<h2 id="contact">Contact</h2>
<?php
include('../includes/confirmationcontact.inc.php');
?>
<p id="contact">Mon profil vous intéresse ?<br>Vous êtes à quatre clics de me le faire savoir :)</p>
<form action="../private/traitement.php" method="post">
	<input type="text" name="nom" maxlength="200" placeholder="// Nom"><br>
	<input type="text" name="email" maxlength="200" placeholder="// Email"><br>
	<textarea name="msg" cols="70" rows="5" maxlength="350" placeholder="// Message"></textarea><br>
	<input type="submit" name="envoyer" value="Envoyer">
</form>
<?php
include('../includes/footer.inc.php');
?>
