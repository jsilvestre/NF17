<?php
function verifierDate($month, $day, $year) {
if (checkdate($month, $day, $year) == true)
{ return 1; }
else
{ return -1; }
}

if(!empty($_POST['submit']))
{
// Recuperation des variables
$login=$_POST['identifiant'];
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$jour=$_POST['jour'];
$mois=$_POST['mois'];
$an=$_POST['an'];
$numSS=$_POST['numSS'];

// Verification de la date
verifierDate($mois,$jour,$an);
// Creation de la date
$date=$an.'-'.$mois.'-'.$jour;
// Creation de la requete
$req=$db->prepare('INSERT INTO utilisateur VALUES(?,?,?,?,?)');
// Execution de la requete
$req->execute(array($identifiant,$numSS,$nom,$prenom,$date));
$req->closeCursor();

}
?>

<div id="wrapper">
	<div class="box">
		<h2>Fenêtre principale</h2>
		<form method="post" action="index.php?page=contact/creation">
			<p>  Nom d'utilisateur : <input type="text" name="login" /><BR>
			Nom: <input type="text" name="nom" /> <BR>
			Prénom : <input type="text" name="prenom" /> <BR>
			Date de naissance (JJ MM AAAA): <input type="text" name="jour" /> - <input type="text" name="mois" /> - <input type="text" name="an" /> <BR>
			Numéro de sécurité sociale : <input type="text" name="numSS" /> <BR>
			<input type="submit" value="Valider" />
			</p>

	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<li><a href="index.php?page=./contact/creation">Creation d'un contact</a></li>
		<li><a href="index.php?page=./contact/modif">modification d'un contact</a></li>
		<li><a href="index.php?page=./contact/supprim">Suppression d'un contact</a></li>
	</ul>
</div>
