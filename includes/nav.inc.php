	<nav id="gen">
		<a href="http://elisabethazemard.fr/pages/apropos.php" <?php active('http://elisabethazemard.fr/pages/apropos.php');?>>A propos</a> //
		<a href="http://elisabethazemard.fr/pages/contact.php" <?php active('http://elisabethazemard.fr/pages/contact.php');?>>Contact</a>
		<?php
		if(isset($_SESSION['level']) && $_SESSION['level'] == 1){
			echo ' // <a href="http://elisabethazemard.fr/private/deconnexion.php">Déconnexion</a>';
		}
		?>
	</nav>
<section>
