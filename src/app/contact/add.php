<HTML>
<BODY>
<?php
$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$bdd = new PDO('mysql:host=localhost;dbname=nf17', 'root', '', $pdo_options);
	
// Recuperation des variables
$login=$_POST['login'];
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$jour=$_POST['jour'];
if($jour>31 || $jour<1)
	echo "il y a une erreur de saisie dans le jour";
$mois=$_POST['mois'];
if($mois>12|| $mois<1)
	echo "il y a une erreur de saisie dans le jour";
$an=$_POST['an'];
$numSS=$_POST['numSS'];
if($numSS<1)
	echo "il y a une erreur de saisie dans le jour";

// Creation de la date
$date=$an.'-'.$mois.'-'.$jour;
// Creation de la requete
$req=$bdd->prepare('INSERT INTO contact VALUES(?,?,?,?,?)');
// Execution de la requete
$req->execute(array($login,$numSS,$nom,$prenom,$date));
$req->closeCursor();

?>

</BODY>
</HTML>