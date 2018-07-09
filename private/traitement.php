<?php
session_start();
include('../includes/connexion.inc.php');

// PRISE DE CONTACT DEPUIS LA PAGE CONTACT.PHP
if(isset($_POST['envoyer'])){
	if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['msg']) && !empty($_POST['msg'])){
		$nom		= addslashes(htmlspecialchars($_POST['nom']));
		$email	= htmlspecialchars($_POST['email']);
		$msg		= nl2br(addslashes(htmlspecialchars($_POST['msg'])));
		$sql		= "INSERT INTO contacts (nom,email,message) VALUES ('$nom','$email','$msg')";

		if(mysqli_query($connexion,$sql)){
			$to				= 'elie.azemard@gmail.com';
			$from			= $_POST['email'];
			$nom			= $_POST['nom'];
			$subject	= 'Portfolio : Quelqu\'un a rempli ton formulaire de contact ! :)';
			$message	= $nom.' a écrit le message suivant : '. $_POST['msg'];
			$headers	= 'From:'.$from;

			if(mail($to,$subject,$message,$headers)){
					$_SESSION['message'] = '<p class="success">Merci pour votre message, '.$nom.' !</p>';
					header('location:../pages/confirmation.php');
				}
			}

	}else{
		$_SESSION['message'] = '<p class="error">Tous les champs doivent être remplis !</p>';
		header('location:../pages/contact.php');
	}

// CONNEXION DE L'ADMIN
}else if(isset($_POST['connexion'])){
	if(isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['mdp']) && !empty($_POST['mdp'])){
		$login		= addslashes(htmlspecialchars($_POST['login']));
		$mdp			= hash('sha256', htmlspecialchars($_POST['mdp']));
		$sql			= "SELECT * FROM users WHERE login='$login'";
		$reponse	= mysqli_query($connexion,$sql);

		if(mysqli_num_rows($reponse) > 0){
			if(mysqli_query($connexion,$sql)){
				while($r = mysqli_fetch_array($reponse)){
					if($login == $r['login'] && $mdp == $r['motdepasse']){
						$_SESSION['login']		= $r['login'];
						$_SESSION['level']		= $r['level'];
						$_SESSION['id']				= $r['id'];
						$_SESSION['message']	= '<p class="success">Hello, not so stranger ;)</p>';
						header('location:../pages/portfolio.php');
					}
				}
			}
		}else{
				header('location:../pages/404.php');
		}
	}

/* ----- GESTION PROJETS ----- */

// CREATION D'UN PROJET
}else if(isset($_POST['new']) || isset($_GET['new'])){

	if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['tag']) && !empty($_POST['tag']) && isset($_POST['description']) && !empty($_POST['description']) && isset($_POST['logiciels']) && !empty($_POST['logiciels']) && isset($_POST['MAX_FILE_SIZE']) && !empty($_POST['MAX_FILE_SIZE'])){
		$nom				= strtolower(addslashes(htmlspecialchars($_POST['nom'])));
		$tag				= $_POST['tag'];
		$desc				= nl2br(addslashes(htmlspecialchars($_POST['description'])));
		$logiciels	= implode(' // ', $_POST['logiciels']);

		// UPLOAD IMAGE
		$maxSize	= 31457280; // 30Mo
		$type			= array('image/jpg','image/jpeg','image/gif','image/png','video/*');

		if( $_FILES['couv']['size'] > $maxSize || $_FILES['imageprojet']['size'] > $maxSize ){
			$_SESSION['message'] = '<p class="error">L\'image est trop lourde.</p>';
			header('location:../pages/categorie.php?modif=new');
		}else if( !in_array($_FILES['couv']['type'],$type) || !in_array($_FILES['imageprojet']['type'],$type) ){
			$_SESSION['message'] = '<p class="error">Au moins un des fichiers n\'est pas du bon type</p>';
			header('location:../pages/categorie.php?modif=new');
		}else{
			$nomCouv						= strtolower($_FILES['couv']['name']);
			$destinationCouv		= '../imagesuploads/'.$nomCouv;
			$directoryImageCouv	= 'imagesuploads/'.$nomCouv;
			$tmpNameCouv				= $_FILES['couv']['tmp_name'];
			$nomImageP					= strtolower($_FILES['imageprojet']['name']);
			$destinationImageP	= '../imagesuploads/'.$nomImageP;
			$directoryImageP		= '/imagesuploads/'.$nomImageP;
			$tmpNameImageP			= $_FILES['imageprojet']['tmp_name'];
		}

		if(move_uploaded_file($tmpNameCouv,$destinationCouv) && move_uploaded_file($tmpNameImageP,$destinationImageP) ){
			$sql	= "INSERT INTO projets (nom,tag,description,logiciels,couv,attachement) VALUES ('$nom','$tag','$desc','$logiciels','$directoryImageCouv','$directoryImageP')";
		}else{
			$_SESSION['message'] = '<p class="error">N\'oublie pas de remplir tous les champs!</p>';
			header('location:../pages/categorie.php?modif=new');
		}

		if(mysqli_query($connexion,$sql)){
			$_SESSION['message'] = '<p class="success">Le projet a bien été créé.</p>';
			header('location:../pages/portfolio.php');
			mysqli_close($connexion);
		}else{
			$_SESSION['message'] = '<p class="error">La création du projet a échoué.</p>';
			header('location:../pages/categorie.php?modif=new');
		}
	}else{
		$_SESSION['message'] = '<p class="error">Erreur lors du déplacement de l\'image.</p>';
		header('location:../pages/categorie.php?modif=new');
	}

// MISE A JOUR D'UN PROJET
}else if(isset($_POST['update'])){
	$id = $_POST['id'];
	if(isset($_POST['nom']) && !empty($_POST['nom']) || isset($_POST['tag']) && !empty($_POST['tag']) || isset($_POST['logiciels']) && !empty($_POST['logiciels']) || isset($_POST['description']) && !empty($_POST['description']) || isset($_POST['MAX_FILE_SIZE']) && !empty($_POST['MAX_FILE_SIZE'])){
		switch ($_GET['modiftype']){

			case 'updatenom':
				$champ = 'nom';
				$modif = strtolower(addslashes(htmlspecialchars($_POST['nom'])));
			break;

			case 'updatetag':
				$champ = 'tag';
				$modif = htmlspecialchars($_POST['tag']);
			break;

			case 'updatelogiciels':
				$champ = 'logiciels';
				$modif = implode(' // ', $_POST['logiciels']);
			break;

			case 'updatedesc':
				$champ = 'description';
				$modif = htmlspecialchars($_POST['description']);
			break;

			case 'updateimagep':
				$maxSize 	= 31457280; // 30Mo
				$type 		= array('image/jpg','image/jpeg','image/gif','image/png');

				if($_FILES['imageprojet']['size'] > $maxSize ){
					$_SESSION['message'] = '<p class="error">L\'image est trop lourde.</p>';
					header('location:../pages/projet.php?modif=updateimagep');
				}else{
					$nomImageP					= strtolower($_FILES['imageprojet']['name']);
					$destinationImageP	= '../imagesuploads/'.$nomImageP;
					$directoryImageP		= '/imagesuploads/'.$nomImageP;
					$tmpNameImageP			= $_FILES['imageprojet']['tmp_name'];

					if(move_uploaded_file($tmpNameImageP,$destinationImageP)){
						$champ = 'attachement';
						$modif = $directoryImageP;
					}else{
						header('location:../pages/404.php');
					}
				}
			break;
		}

		$sql = "UPDATE projets SET $champ='$modif' WHERE id=$id";
		if(mysqli_query($connexion,$sql)){
			$_SESSION['message'] = '<p class="success">Le projet a bien été mis à jour.</p>';
			header('location:../pages/projet.php?projet='.$id.'');
			mysqli_close($connexion);
		}else{
			$_SESSION['message'] = '<p class="error">La mise à jour du projet a échoué.</p>';
			header('location:../pages/projet.php?projet='.$id.'');
		}
	}else{
		$_SESSION['message'] = '<p class="error">Le champ n\'est pas rempli !.</p>';
		header('location:../pages/projet.php?projet='.$id.'');
	}

// SUPPRESSION D'UN PROJET
}else if(isset($_GET['suppr']) && $_GET['suppr'] == 'delete'){
	$id		= $_GET['id'];
	$sql	= "DELETE FROM projets WHERE id=$id";
	if(mysqli_query($connexion,$sql)){
		$_SESSION['message'] = '<p class="success">Le projet a bien été supprimé.</p>';
		header('location:../pages/portfolio.php');
		mysqli_close($connexion);
	}else{
		header('location:../pages/404.php');
	}

// NOUVEL UTILISATEUR / CREATION DE COMPTE
}else if(isset($_POST['creerUnCompte'])){
	if(isset($_POST['login']) && !empty(($_POST['login'])) && isset($_POST['motdepasse']) && !empty(($_POST['motdepasse']))){
		$login			= addslashes(htmlspecialchars($_POST['login']));
		$motdepasse	= hash('sha256', addslashes(htmlspecialchars($_POST['motdepasse'])));
		$level			= $_POST['level']; 
		$sql				= "INSERT INTO users (login,motdepasse,level) VALUES ('$login','$motdepasse','$level')";
		if(mysqli_query($connexion,$sql)){
			$SESSION['message'] = '<p id="success">Le compte a bien été créé. Connectez-vous !';
			header('location:connexion.php');
		}else{
			$SESSION['message'] = '<p id="error">Echec de la création du compte.</p>';
			header('location:creation.php');
		}
	}

// ERREUR
}else{
	header('location:../pages/404.php');
}
?>
