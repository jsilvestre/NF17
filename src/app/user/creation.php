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
$login=$_POST['login'];
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$jour=$_POST['jour'];
$mois=$_POST['mois'];
$an=$_POST['an'];
$numSS=$_POST['numSS'];
if($numSS<1)
	echo "il y a une erreur de saisie dans le jour";
$mdp=$_POST['mdp'];


// Creation de la date
$date=$an.'-'.$mois.'-'.$jour;
// Creation de la requete
$req=$db->prepare('INSERT INTO utilisateur VALUES(?,?,?,?,?,?)');
// Execution de la requete
$req->execute(array($login,$numSS,$nom,$prenom,$date,$mdp));
$req->closeCursor();

}
?>



<div id="wrapper">
	<div class="box">
		<h2>Fenêtre principale</h2>
		<form method="post" action="index.php?page=user/creation">
				<p>  Nom d'utilisateur : <input type="text" name="login" /><BR>
				Nom: <input type="text" name="nom" /> <BR>
				Prénom : <input type="text" name="prenom" /> <BR>
				Date de naissance (JJ MM AAAA): <input type="text" name="jour" /> - <input type="text" name="mois" /> - <input type="text" name="an" /> <BR>
				Numéro de sécurité sociale : <input type="text" name="numSS" /> <BR>
				Mot de passe : <input type="text" name="mdp" /> <BR>
				<input type="submit" value="Valider" name="submit" />
</p>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<li><a href="index.php?page=./user/creation">Creation utilisateur</a></li>
	</ul>
</div>
