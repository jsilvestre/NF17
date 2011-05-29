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
$nom=$_POST['nom'];
$rue=$_POST['nom_rue'];
$cp=$_POST['cp'];
$ville=$_POST['ville'];


// Creation de la requete
$req=$db->prepare('INSERT INTO organisation VALUES(?)');
// Execution de la requete
$req->execute(array($nom));
$req->closeCursor();

$req=$db->prepare('INSERT INTO adresse (nom_rue,cp,ville,organisation) VALUES(?,?,?,?)');
$req->execute(array($rue,$cp,$ville,$nom));
}
?>



<div id="wrapper">
	<div class="box">
		<h2>Fenêtre principale</h2>
		<form method="post" action="index.php?page=firm/creation">
		<p>
				Nom de l'organisation : <input type="text" name="nom" /> <BR>
				Nom de rue : <input type="text" name="nom_rue" /> <BR>
				Code postal: <input type="text" name="cp" /> <BR>
				Ville : <input type="text" name="ville" /> <BR>
				<input type="submit" value="Valider" name="submit" />
		</p>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<li><a href="index.php?page=firm/creation">Creation organisation</a></li>
	</ul>
</div>
