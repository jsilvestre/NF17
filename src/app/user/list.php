<?php

	// initialise la variable d'affichage
	$display = '';
	$display2="";

	// En cas de premiere page, on affiche la liste des utilisateurs dans la base de données
	if(empty($_GET['id']))
	{
		$req=$db->prepare('SELECT login from utilisateur');
		// Execution de la requete
		$req->execute();
		while($result = $req->fetch(PDO::FETCH_ASSOC))
		{
			$display.= '<a href="index.php?page=user/list&id='.$result['login'].'">'.$result['login'].'</a>';
			$display.= "<br />";
		}
		$req->closeCursor();
		$display2.='<li><a href="index.php?page=user/creation">Création utilisateur</a></li>';
		
	}
	else // Si un utilisateur a ete selectionne, on affiche la liste des informations le concernant
	{
		$req=$db->prepare("select * from utilisateur where login=?");
		$req->execute(array($_GET['id']));
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$display.= "Nom d utilisateur : ".$result['login']."<br />" ;
		$display.= "Nom  : ".$result['nom']."<br />" ;
		$display.= "Prénom : ".$result['prenom']."<br />" ;
		$display.= "Date de naissance : ".$result['dateNaissance']."<br />" ;
		$display.= "Numero de securite sociale : ".$result['numSS']."<br /> <br /><br /><br />" ;
		$display.= '<a href="index.php?page=user/list"> Retour </a>';
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
	<?php echo $display2; ?>
	</ul>
</div>