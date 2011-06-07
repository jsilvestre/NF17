<?php
	$display = '';
	$displayAction = '';
		// En cas de premiere page, on affiche la liste des utilisateurs dans la base de données
		// Si aucun ID n'est passé, on affiche la liste des utilisateurs dans la base de données
	if(empty($_GET['id']))
	{
		$req=$db->prepare("SELECT numSS,nom,prenom from contact");
		// Execution de la requete
		$req->execute();
		while($result = $req->fetch(PDO::FETCH_ASSOC))
		{
			$display.= '<a href="index.php?page=contact/list&id='.$result['numSS'].'">'.$result['prenom'].' '.$result['nom'].'</a>';
			$display.= '<br />';
		}
		
		$req->closeCursor();
		$displayAction.='<li><a href="index.php?page=contact/creation">Création d\'un contact</a></li>';		
	}
	else // Si un utilisateur a ete selectionne, on affiche la liste des informations le concernant
	{
		$req=$db->prepare("select * from contact where numSS=?");
		$req->execute(array($_GET['id']));
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$display.= "Nom  : ".$result['nom']."<br />";
		$display.= "Prénom : ".$result['prenom']."<br />";
		$display.= "Date de naissance : ".$result['dateNaissance']."<br />";
		$display.= "Numero de securite sociale : ".$result['numSS']."<br />";
		$display.= "Organisation :".$result['organisation']."<br />";
		$display.= "Numero de securite sociale : ".$result['poste']."<br /><br />";
		$display.= '<a href="index.php?page=user/list">Retour </a>';

		$displayAction.='<li><a href="index.php?page=contact/modify&id='.$result['numSS'].'">Modifier le contact</a></li>';				
		$displayAction.='<li><a href="index.php?page=contact/delete&id='.$result['numSS'].'">Supprimer le contact (/!\ non réversible)</a></li>';		
	}
	?>

<div id="wrapper">
	<div class="box">
		<h2>Accueil</h2>
		<p> <?php echo $display; ?>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<?php echo $displayAction; ?>
	</ul>
</div>