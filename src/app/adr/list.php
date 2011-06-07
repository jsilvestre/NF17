<?php

	// initialise les variables d'affichage
	$display = '';
	$displayAction = '';

	$req=$db->prepare("select * from adresse where pkArtif=?");
	$req->execute(array($_GET['id']));
	if ($req->rowCount()==1)
	{
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$display.= "Code postal : ".$result['cp']."<br />";
		$display.= "Ville  : ".$result['ville']."<br />";
		$display.= "adresse : ".$result['numero'].",".$result['nom_rue']."<br /><br />";
		$display.= '<a href="index.php?page=firm/list">Retour </a>';
	}
	else
	{
	$erreur="Cette adresse n'existe pas ou plus";
	}
	$req->closeCursor();
	$displayAction.='<li><a href="index.php?page=adr/modify&id='.$result['pkArtif'].'">Modifier l\'adresse</a></li>';				
	$displayAction.='<li><a href="index.php?page=adr/delete&id='.$result['pkArtif'].'">Supprimer l\'adresse (/!\ non réversible)</a></li>';		
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