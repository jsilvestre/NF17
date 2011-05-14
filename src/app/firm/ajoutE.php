<HTML>
<BODY>
<?php
$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$bdd = new PDO('mysql:host=localhost;dbname=nf17', 'root', '', $pdo_options);
	
// Recuperation des variables

// Creation de la requete
$req=$bdd->prepare('INSERT INTO organisation VALUES(?)');

// Execution de la requete
$req->execute(array($_POST['nom']));
$req->closeCursor();
?>

</BODY>
</HTML>