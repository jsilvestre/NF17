<?php
if(!empty($_POST['submit'])) // si le formulaire a été validé
{
	// Récuperation des variables
	$login=$_POST['login'];
	$nom=$_POST['nom'];
	$prenom=$_POST['prenom'];
	$jour=$_POST['jour'];
	$mois=$_POST['mois'];
	$an=$_POST['an'];
	$numSS=$_POST['numSS'];
	$mdp=$_POST['mdp'];
	$is_special=$_POST['is_special'];
	
	$is_special = ($is_special == "on") ? 1 : 0;
	
	if(checkdate($mois, $jour, $an) !== true)
		$erreur = "Il y a une erreur de saisie dans la date.";

	// Création de la date
	$date=$an.'-'.$mois.'-'.$jour;
	// Création de la requete
	$req=$db->prepare('INSERT INTO utilisateur VALUES(?,?,?,?,?,?,?)');
	// Exécution de la requete
	$req->execute(array($numSS,$login,$nom,$prenom,$date,$mdp,$is_special));
	$req->closeCursor();
	
	header('Location: index.php?page=general/message&type=confirm&msg=L\'utilisateur a bien été créé.&return=user/creation');
}
?>
<div id="wrapper">
	<div class="box">
		<h2>Fenêtre principale</h2>
		<form method="post" action="index.php?page=user/creation">
				<p>Nom d'utilisateur : <input type="text" name="login" /><br />
				Nom: <input type="text" name="nom" /><br />
				Prénom : <input type="text" name="prenom" /><br />
				Date de naissance (JJ MM AAAA): <input type="text" name="jour" /> - <input type="text" name="mois" /> - <input type="text" name="an" /><br />
				Numéro de sécurité sociale : <input type="text" name="numSS" /><br />
				Mot de passe : <input type="password" name="mdp" /><br />
				Administrateur : <input type="checkbox" name="is_special" /><br />
				<input type="submit" value="Valider" name="submit" />
				</p>
		</form>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<li>Aucune action possible</li>
	</ul>
</div>
