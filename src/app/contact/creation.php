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
$poste=$_POST['poste'];
$firm=$_POST['firm'];

// Verification de la date
//verifierDate($mois,$jour,$an);
// Creation de la date
$date=$an.'-'.$mois.'-'.$jour;
// Creation de la requete
$req=$db->prepare('INSERT INTO contact VALUES(?,?,?,?,?,?)');
// Execution de la requete
$req->execute(array($login,$numSS,$nom,$prenom,$date));


// ON VERIFIE SI L'ENTREPRISE EXISTE
$req=$db->prepare('select nom from organisation');
$req->execute();
$flag=0;
while($result = $req->fetch(PDO::FETCH_ASSOC))
			{
				if ($firm == $result['nom'])
					$flag=1;
			}

	if ( $flag==1)
		echo "CA MARCHE";
	else 
		echo "CA MARCHE PAS";
$req->closeCursor();

}
?>

<div id="wrapper">
	<div class="box">
		<h2>Fenêtre principale</h2>
		<form method="post" action="index.php?page=contact/creation">
			<p>  Nom d'utilisateur : <input type="text" name="login" /></br>
			Nom: <input type="text" name="nom" /> </br>
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
