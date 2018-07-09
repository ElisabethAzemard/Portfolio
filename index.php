<?php
session_start();
include('includes/headerindex.inc.php');
include('includes/nav.inc.php');
include('includes/connexion.inc.php');

echo '<h2 id="projets">Projets</h2>';

$sql				= "SELECT * FROM projets ORDER BY id DESC";
$reponse		= mysqli_query($connexion,$sql);
$directory	= 'imagesuploads';

while($r = mysqli_fetch_array($reponse)){
	echo	'<article>';
	if(isset($_SESSION['level']) && $_SESSION['level'] == 1){
		echo	'<div id="modifcouv">
						<a href="../private/traitement.php?suppr=delete&id='.$r['id'].'"><img src="../images/croix.png" alt="supprimer"></a>
					</div>';
	}
	echo		'<a href="http://elisabethazemard.fr/pages/projet.php?projet='.$r['id'].'"><img src="'.$r['couv'].'" alt="couv" class="couv"></a>
					<h3><a href="/pages/projet.php?projet='.$r['id'].'">'.$r['nom'].'</a></h3>
				</article>';
}
echo '</div>';
include('includes/footer.inc.php');
?>
