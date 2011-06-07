<?php

if(!empty($_POST['submit'])) // si le formulaire a été validé
{
	// Récuperation des variables
	if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['jour']) && !empty($_POST['mois']) && 
		!empty($_POST['an']) && !empty($_POST['numSS']) && !empty($_POST['poste']) && !empty($_POST['firm']))
	{
		$firm=$_POST['firm'];
		$nom=$_POST['nom'];
		$prenom=$_POST['prenom'];
		$jour=$_POST['jour'];
		$mois=$_POST['mois'];
		$an=$_POST['an'];
		$numSS=$_POST['numSS'];
		$poste=$_POST['poste'];
	
		$is_special = (!empty($_POST['is_special']) && $_POST['is_special'] == "on") ? 1 : 0;

		if(is_integer((int)$mois) && is_integer((int)$jour) && is_integer((int)$an) && checkdate($mois, $jour, $an) == true)
		{
			// Création de la date
			$date=$an.'-'.$mois.'-'.$jour;
			$req=$db->prepare("select * from contact where numSS=? OR (nom=? AND prenom=?)");
			$req->execute(array($numSS,$nom,$prenom));
			if($req->rowCount() == 0)
			{
				// Création de la requete
				$req=$db->prepare('INSERT INTO contact VALUES(?,?,?,?,?,?)');
				// Exécution de la requete
				$req->execute(array($numSS,$nom,$prenom,$date,$firm,$poste));
				$req->closeCursor();
				
				header('Location: index.php?page=general/message&type=confirm&msg=L\'utilisateur '.$nom." ".$prenom.' a bien été créé.&retour=user/creation');
			}
			else
			{
				$erreur = "Un contact avec ce login ou ce numéro de sécurité sociale existe déjà dans la base de données.";
			}
		}
		else
		{
			$erreur = "Il y a une erreur de saisie dans la date.";
		}
	}
	else 
	{
		$erreur = "Un des champs n'a pas été rempli ou a été mal rempli.";
	}
}


if(!empty($erreur))
{
	$erreur = '<p class="error">'.$erreur.'</p>';
}
else
{
	$erreur = "";
}

?>

<div id="wrapper">
	<div class="box">
		<h2>Fenêtre principale</h2>
		<form method="post" action="index.php?page=contact/creation">
			<p>
			Nom : <input type="text" name="nom" /> </br>
			Prénom : <input type="text" name="prenom" /> </br>
			Date de naissance (JJ MM AAAA): <input type="text" name="jour" /> - <input type="text" name="mois" /> - <input type="text" name="an" /> </br>
			Numéro de sécurité sociale : <input type="text" name="numSS" /> </br></br></br>
			Poste occupé : <input type="text" name="poste" /> </br>
			Entreprise : <input type="text" name="firm" /> </br>
			<input type="submit" value="Valider" name="submit" />
			</p>

	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<li><a href="index.php?page=contact/creation">Creation d'un contact</a></li>
	</ul>
</div>
