<?php
session_start();
include('../includes/header.inc.php');
include('../includes/nav.inc.php');
include('../includes/connexion.inc.php');
if(isset($_GET['tag'])){
	$tag = $_GET['tag'];
		switch($_GET['tag']){
			case 'Ui':
				$tag = 'UI';
			break;

			case 'Illus':
				$tag = 'Illustration';
			break;

			case 'Photo':
				$tag = 'Photomontage';
			break;

			case 'Print':
				$tag = 'Print';
			break;

			case 'Motion':
				$tag = 'Motion';
			break;
		}

	echo '<h2 id="projets">'.$tag.'</h2>';
	$sql = "SELECT * FROM projets WHERE tag='$tag' ORDER BY id DESC";
	$reponse = mysqli_query($connexion,$sql);
		while($r = mysqli_fetch_array($reponse)){
			echo '<article>';
			if(isset($_SESSION['level']) && $_SESSION['level'] == 1){
				echo	'<div id="modifcouv">
								<a href="../private/traitement.php?suppr=delete&id='.$r['id'].'"><img src="../images/croix.png" alt="supprimer"></a>
							</div>';
			}
			echo	'<a href="projet.php?projet='.$r['id'].'" id="couverture"><img src="../'.$r['couv'].'" alt="couv" class="couv"></a>
						<h3><a href="projet.php?projet='.$r['id'].'">'.$r['nom'].'</a></h3>
			</article>';
		}

}else if(isset($_GET['modif'])){
	if($_GET['modif'] == 'new'){
		include('../includes/messageconfirmation.inc.php');
		echo	'<h2 id="new">Nouveau Projet</h2>';
		echo	'<form action="http://elisabethazemard.fr/private/traitement.php?new" method="post" enctype="multipart/form-data">
							<input type=text name="nom" maxlength="200" placeholder="// Nom du projet"><br>
							<select name="tag">
								<option selected value="Autre">Type de projet</option>
								<option value="UI">UI</option>
								<option value="Illustration">Illustration</option>
								<option value="Photomontage">Photomontage</option>
								<option value="Print">Print</option>
								<option value="Motion">Motion</option>
							</select><br>
							<textarea name="description" cols="70" rows="6" maxlength="420" placeholder="// Description"></textarea><br>
							<label for="couv">
								Image de couverture (format carré)
								<input type="hidden" name="MAX_FILE_SIZE" value="31457280">
								<input type="file" name="couv">
							</label><br>
							<label for="imageprojet">
								Image du projet
								<input type="hidden" name="MAX_FILE_SIZE" value="31457280">
								<input type="file" name="imageprojet">
							</label><br>
							<label for="cb1">
								<input type="checkbox" id="cb1" name="logiciels[]" value="Illustrator">Illustrator
							</label><br>
							<label for="cb2">
								<input type="checkbox" id="cb2" name="logiciels[]" value="Photoshop">Photoshop
							</label><br>
							<label for="cb3">
								<input type="checkbox" id="cb3" name="logiciels[]" value="After Effects">After Effects
							</label><br>
							<input type="submit" name="new" value="Créer le projet">
					</form>';
	}
}else{
	header('location:404.php');
}
include('../includes/footer.inc.php');
?>
