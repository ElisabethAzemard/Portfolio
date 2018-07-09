<?php
session_start();
include('../includes/header.inc.php');
include('../includes/nav.inc.php');
include('../includes/connexion.inc.php');

if(isset($_GET['projet'])){
	$id					= $_GET['projet'];
	$sql				= "SELECT * FROM projets WHERE id=$id";
	$reponse		= mysqli_query($connexion,$sql);

	while($r = mysqli_fetch_array($reponse)){
		$nomprojet				= '<h2 id="titreprojet">'.$r['nom'].'</h2>';
		$tagprojet				= '<p id="tag">// '.$r['tag'].'</p>';
		$logicielsprojet	= '<p>// '.$r['logiciels'].'</p>';
		$descprojet				= '<div id="description">'.$r['description'].'</div>';
		$imageprojet			= '<article id="galerie">
													<img src="../'.$r['attachement'].'" alt="image du projet">
							   				</article>';
		$boutonsuppr			= '<a href="../private/traitement.php?suppr=delete&id='.$r['id'].'"><img src="../images/croix.png" alt="supprimer" id="supprprojet"></a>';

		include('../includes/messageconfirmation.inc.php');
		echo '<div class="modif">'.$nomprojet;

		if(isset($_SESSION['level']) && $_SESSION ['level'] == 1){
			echo	'<a href="?modif=updatenom&id='.$r['id'].'"><img src="../images/pen.png" alt="modifier"></a>';
			echo $boutonsuppr.'</div>';
		}

		echo '<div class="modif">'.$tagprojet;

		if(isset($_SESSION['level']) && $_SESSION ['level'] == 1){
			echo	'<a href="?modif=updatetag&id='.$r['id'].'"><img src="../images/pen.png" alt="modifier"></a>
					</div>';
		}

		echo '<div class="modif">'.$logicielsprojet;

		if(isset($_SESSION['level']) && $_SESSION ['level'] == 1){
			echo	'<a href="?modif=updatelogiciels&id='.$r['id'].'"><img src="../images/pen.png" alt="modifier"></a>
					</div>';
		}

		echo '<div class="modif">'.$descprojet;
		if(isset($_SESSION['level']) && $_SESSION ['level'] == 1){
			echo	'<a href="?modif=updatedesc&id='.$r['id'].'"><img src="../images/pen.png" alt="modifier"></a>
					</div>';
		}

		if(strpos($nomprojet, 'motion') !== false) {
			echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZTHGQiOmPt4?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
		}

		echo	'<div class="modif">'.$imageprojet;
		if(isset($_SESSION['level']) && $_SESSION ['level'] == 1){
			echo	'<a href="?modif=updateimagep&id='.$r['id'].'" id="modifimagep"><img src="../images/camera.png" alt="modifier"></a>
					</div>';
		}


	}

// MODIFICATION & SUPPRESSION DE PROJET
}else if(isset($_SESSION['level']) && $_SESSION['level'] == 1){

	if(isset($_GET['modif'])){

			$id				= $_GET['id'];
			$sql			= "SELECT * FROM projets WHERE id=$id";
			$reponse	= mysqli_query($connexion,$sql);

			while($r = mysqli_fetch_array($reponse)){

				$nomprojet				= '<div class="modif"><h2 id="titreprojet">'.$r['nom'].'</h2></div>';
				$tagprojet				= '<div class="modif"><p id="tag">// '.$r['tag'].'</p></div>';
				$logicielsprojet	= '<div class="modif"><p>// '.$r['logiciels'].'</p></div>';
				$descprojet				= '<div class="modif"><div id="description">'.$r['description'].'</div></div>';
				$imageprojet			= '<div class="modif"><article id="galerie">
																<img src="../'.$r['attachement'].'" alt="image du projet">
															</article>
														</div>';
				$openform 				= '<form action="http://elisabethazemard.fr/private/traitement.php?modiftype='.$_GET['modif'].'" method="post" enctype="multipart/form-data">
								<input type=hidden name="id" value="'.$r['id'].'">';
				$closeform = '<br><input type="submit" name="update" value="Mettre à jour le projet">
						</form>';

				switch ($_GET['modif']) {
					case 'updatenom':
						echo	$openform.'<input type=text name="nom" maxlength="200" placeholder="Nom du projet" value="'.$r['nom'].'" id="nomprojet">'.$closeform.
								$tagprojet.$logicielsprojet.$descprojet.$imageprojet;
					break;

					case 'updatetag':
						echo	$nomprojet.$openform.
								'<select name="tag">
									<option selected value="Autre">Type de projet</option>
									<option selected value="Autre">Avant : '.$r['tag'].'</option>
									<option value="UI">UI</option>
									<option value="Illustration">Illustration</option>
									<option value="Photomontage">Photomontage</option>
									<option value="Print">Print</option>
									<option value="Motion">Motion</option>
								</select>'.$closeform.$logicielsprojet.$descprojet.$imageprojet;
					break;

					case 'updatelogiciels':
						echo	$nomprojet.$tagprojet.$openform.
								'<label for="cb1">
									<input type="checkbox" id="cb1" name="logiciels[]" value="Illustrator">Illustrator
								</label><br>
								<label for="cb2">
									<input type="checkbox" id="cb2" name="logiciels[]" value="Photoshop">Photoshop
								</label><br>
								<label for="cb3">
									<input type="checkbox" id="cb3" name="logiciels[]" value="After Effects">After Effects
								</label>'
									.$closeform.$descprojet.$imageprojet;
					break;

					case 'updatedesc';
						echo	$nomprojet.$tagprojet.$logicielsprojet.$openform.
								'<textarea name="description" cols="70" rows="6" maxlength="420" placeholder="Description">'
									.$r['description'].
								'</textarea>'
									.$closeform.$imageprojet;
					break;

					case 'updateimagep';
						echo	$nomprojet.$tagprojet.$logicielsprojet.$descprojet.$openform.
								'<label for="imageprojet">Image du projet
									<input type="hidden" name="MAX_FILE_SIZE" value="31457280">
									<input type="file" name="imageprojet">
								</label>'
									.$closeform;
					break;

					default:
						echo	$nomprojet.$tagprojet.$openform.
								'<label for="cb1">
									<input type="checkbox" id="cb1" name="logiciels[]" value="Illustrator">Illustrator
								</label><br>
								<label for="cb2">
									<input type="checkbox" id="cb2" name="logiciels[]" value="Photoshop">Photoshop
								</label><br>
								<label for="cb3">
									<input type="checkbox" id="cb3" name="logiciels[]" value="After Effects">After Effects
								</label>'
									.$closeform.$descprojet.$imageprojet.'';
					break;
				}
			}
		}
}else{
	header('location:404.php');
}
include('../includes/footer.inc.php');
?>
