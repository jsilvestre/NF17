<?php

	// initialise la variable d'affichage
	$display = '';

	// En cas de premiere page, on affiche la liste des utilisateurs dans la base de données
	if(empty($_GET['id']))
	{
		$req=$db->prepare('SELECT login from utilisateur');
		// Execution de la requete
		$req->execute();
		while($result = $req->fetch(PDO::FETCH_ASSOC))
		{
			$display.= '<a href="index.php?page=./user/list&id='.$result['login'].'">'.$result['login'].'</a>';
			$display.= "<br />";
		}
		$req->closeCursor();
	}
	else // Si un utilisateur a ete selectionne, on affiche la liste des informations le concernant
	{
		$req=$bdd->prepare("select * from utilisateur where login=?");
		$req->execute(array($_GET['id']));
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$display.= "nom d utilisateur : ".$result['login']."<br />" ;
		$display.= "nom  : ".$result['nom']."<br />" ;
		$display.= "Prenom : ".$result['prenom']."<br />" ;
		$display.= "Date de naissance : ".$result['dateNaissance']."<br />" ;
		$display.= "Numero de securite sociale : ".$result['numSS']."<br /> <br /><br /><br />" ;
		$display.= '<a href="index.php?page=user/list"> Retour </a>';
	}
?>

<div id="wrapper">
	<div class="box">
		<h2>Accueil</h2>
		<p><?php echo $display; ?></p>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<li><a href="index.php?page=./user/creation">Creation utilisateur</a></li>
	</ul>
</div>