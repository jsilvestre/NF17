<?php

	// initialise la variable d'affichage
	$display = '';

	// En cas de premiere page, on affiche la liste des utilisateurs dans la base de données
	if(empty($_GET['id']))
	{
		$req=$db->prepare('SELECT nom from organisation');
		// Execution de la requete
		$req->execute();
		while($result = $req->fetch(PDO::FETCH_ASSOC))
		{
			$display.= '<a href="index.php?page=./firm/list&id='.$result['nom'].'">'.$result['nom'].'</a>';
			$display.= "<br />";
		}
		$req->closeCursor();
	}
	else // Si un utilisateur a ete selectionne, on affiche la liste des informations le concernant
	{
		$req=$db->prepare("select * from organisation o, adresse a where o.nom=? AND a.organisation=o.nom");
		$req->execute(array($_GET['id']));
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$display.= "Nom : ".$result['nom']."<br />" ;
		// Adresse
		$display.="Adresse : <br />";
		$display.= "	Nom de la rue : ".$result['nom_rue']."<br />" ;
		$display.= "	Code postal : ".$result['cp']."<br />" ;
		$display.= "	Ville : ".$result['ville']."<br /><br /> <br /><br />" ;
		$display.= '<a href="index.php?page=firm/list"> Retour </a>';
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
		<li><a href="index.php?page=firm/creation">Création Organisation</a></li>
	</ul>
</div>