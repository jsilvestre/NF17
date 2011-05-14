<HTML>
<BODY>
<?php

function verifierDate($month, $day, $year) {
if (checkdate($month, $day, $year) == true)
{ return "Date valide calendrier grégorien."; }
else
{ return "C'est quoi ce truc qui est pas une date !?"; }
}

$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$bdd = new PDO('mysql:host=localhost;dbname=nf17', 'root', '', $pdo_options);
	
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

echo verifierDate($mois,$jour,$an);

// Creation de la date
$date=$an.'-'.$mois.'-'.$jour;
// Creation de la requete
$req=$bdd->prepare('INSERT INTO utilisateur VALUES(?,?,?,?,?,?)');
// Execution de la requete
$req->execute(array($login,$numSS,$nom,$prenom,$date,$mdp));
$req->closeCursor();

$req=$bdd->prepare('GRANT ALL on NF17 TO ? @localhost');
$req->execute(array($login));
$req->closeCursor();
?>

</BODY>
</HTML>