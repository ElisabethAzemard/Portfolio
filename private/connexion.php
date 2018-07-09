<?php
session_start();
include('../includes/header.inc.php');
include('../includes/nav.inc.php');
?>
<form action="http://elisabethazemard.fr/private/traitement.php" method="post">
	<input type="text" name="login" maxlength="200" placeholder="Login"><br>
	<input type="password" name="mdp" maxlength="200" placeholder="Mot de passe"><br>
	<input type="submit" name="connexion" value="Connexion">
</form>
<?php
include('../includes/footer.inc.php');
?>
