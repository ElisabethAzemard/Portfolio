<?php
session_start();
include('../includes/header.inc.php');
include('../includes/nav.inc.php');
?>
<form action="http://elisabethazemard.fr/private/traitement.php" method="post">
<fieldset>
<legend>Créer un compte</legend>
	<input type="text" name="login" id="login" maxlength="100" placeholder="Login"> 
	<input type="password" name="motdepasse" id="motdepasse" maxlength="255" placeholder="Mot de passe" >
	<input type="hidden" name="level" value="1" id="1">
	<input type="submit" name="creerUnCompte" value="creerUnCompte">
</fieldset>
<?php
include('../includes/footer.inc.php');
?>
