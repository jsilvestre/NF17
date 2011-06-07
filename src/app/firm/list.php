<?php

	// initialise la variable d'affichage
	$display = '';
	$displayAction='';

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
		
		$displayAction.="<li><a href='index.php?page=firm/creation'>Creer une organisation</a></li>";
	}
	else // Si un utilisateur a ete selectionne, on affiche la liste des informations le concernant
	{
		$req=$db->prepare("select * from organisation o LEFT JOIN adresse a ON o.nom=a.organisation where o.nom=?");
		$req->execute(array($_GET['id']));
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$display.= "Nom : ".$result['nom']."<br />" ;
		if ($result['nom_rue']==NULL AND $result['nom_rue']==NULL AND $result['cp']==NULL AND $result['ville']==NULL) //&& !$result['ville'] && !$result['cp'])// On vérifie si une adresse est en relation avec l' organisation
		{
			$display.="<br />Aucune adresse répertioriée <br /><br />";
		}
		else 
		{			
		// Adresse
			$display.="Adresse : <br />";
			$display.= "	Nom de la rue : ".$result['nom_rue']."<br />" ;
			$display.= "	Code postal : ".$result['cp']."<br />" ;
			$display.= "	Ville : ".$result['ville']."<br /><br /> <br /><br />" ;
			$display.= '<a href="index.php?page=firm/list"> Retour </a>';
			
		}
		$displayAction.='<li><a href="index.php?page=firm/modify&id='.$result['nom'].'">Modifier le nom de l\'organisation</a></li>';
		$displayAction.='<li><a href="index.php?page=firm/creationAdr&id='.$result['nom'].'">Ajouter une adresse</a></li>';
		$displayAction.='<li><a href="index.php?page=firm/modifyAdr&id='.$result['nom'].'">Modifier une adresse</a></li>';
		$displayAction.='<li><a href="index.php?page=firm/deleteAdr&id='.$result['nom'].'">Supprimer une adresse</a></li>';
		$displayAction.='<li><a href="index.php?page=firm/delete&id='.$result['nom'].'">Supprimer l\'organisation</a></li>';
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
		<?php echo $displayAction; ?>
	</ul>
</div>