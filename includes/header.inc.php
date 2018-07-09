<!doctype html>
<html>
	<head>
		<title>Portfolio Elisabeth Azémard</title>
		<meta name="description" content="blabla">
		<meta name="author" content="Elisabeth Azémard">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
		<link rel="stylesheet" href="http://elisabethazemard.fr/css/stylemobile.css">
		<link rel="stylesheet" href="http://elisabethazemard.fr/css/style.css">
		<link href="https://fonts.googleapis.com/css?family=Didact+Gothic" rel="stylesheet">
	</head>

	<body>
				<div id="content">

	<header>
					<h2>
						<p class="header">Elisabeth</p>
						<a href="http://elisabethazemard.fr/pages/portfolio.php"><img src="http://elisabethazemard.fr/images/logo.png" alt="logo"></a>
						<p class="header">Azémard</p>
					</h2>

					<nav id="projets">
					<?php
					$connexion = mysqli_connect('db724226515.db.1and1.com','dbo724226515','Evilr3g@l','db724226515');
					$tag = array('Ui','Illustration','Photomontage','Print','Motion');
					include('../fonctions/active.php');
					for($i = 0; $i<count($tag); $i++){
						$sql			= "SELECT tag FROM projets WHERE tag = '$tag[$i]' ";
						$reponse	= mysqli_query($connexion,$sql);
						if(mysqli_num_rows($reponse) > 0){
								echo '<a href="http://elisabethazemard.fr/pages/categorie.php?tag='.$tag[$i].'"';
								active('http://elisabethazemard.fr/pages/categorie.php?tag='.$tag[$i].'');
								echo '>'.$tag[$i].'</a>';
						}
					}

					if(isset($_SESSION['level']) && $_SESSION['level'] == 1){
						echo '<a href="http://elisabethazemard.fr/pages/categorie.php?modif=new" id="ajouter">+</a>';
						}
					?>
					</nav>
	</header>
