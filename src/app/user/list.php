<?php
function readAdmin($value) { return ($value) ? "Oui" : "Non"; }

	// initialise les variables d'affichage
	$display = '';
	$displayAction = '';

	// Si aucun ID n'est passé, on affiche la liste des utilisateurs dans la base de données
	if(empty($_GET['id']))
	{
		$req=$db->prepare("SELECT numSS,login,nom,prenom from utilisateur");
		// Execution de la requete
		$req->execute();
		while($result = $req->fetch(PDO::FETCH_ASSOC))
		{
			$display.= '<a href="index.php?page=user/list&id='.$result['numSS'].'">'.$result['prenom'].' '.$result['nom'].' ('.$result['login'].')</a>';
			$display.= '<br />';
		}
		
		$req->closeCursor();
		$displayAction.='<li><a href="index.php?page=user/creation">Création d\'un utilisateur</a></li>';		
	}
	else // Si un utilisateur a ete selectionne, on affiche la liste des informations le concernant
	{
		$req=$db->prepare("select * from utilisateur where numSS=?");
		$req->execute(array($_GET['id']));
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$display.= "Nom d'utilisateur : ".$result['login']."<br />";
		$display.= "Nom  : ".$result['nom']."<br />";
		$display.= "Prénom : ".$result['prenom']."<br />";
		$display.= "Date de naissance : ".strftime('%d/%m/%Y', strtotime($result['dateNaissance']))."<br />";
		$display.= "Numero de securite sociale : ".$result['numSS']."<br />";
		$display.= "Administrateur ? ".readAdmin($result['is_special'])."<br /><br />";
		$display.= '<a href="index.php?page=user/list">Retour </a>';

		$displayAction.='<li><a href="index.php?page=user/modify&id='.$result['numSS'].'">Modifier l\'utilisateur</a></li>';				
		$displayAction.='<li><a href="index.php?page=user/delete&id='.$result['numSS'].'">Supprimer l\'utilisateur (/!\ non réversible)</a></li>';		
	}
?>

<div id="wrapper">
	<div class="box">
		<h2>Utilisateur</h2>
		<p><?php echo $display; ?></p>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
	<?php echo $displayAction; ?>
	</ul>
</div>