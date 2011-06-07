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
		if ($result['nom_rue']==NULL AND $result['nom_rue']==NULL AND $result['cp']==NULL AND $result['ville']==NULL) 
		{
			$display.="<br />Aucune adresse répertioriée <br /><br />";
		}
		else 
		{	
			// Creation du tableau contenant les adresses
			$display.= '<table>
					<tr>
						<th>Code postal</th>
						<th>Ville</th>
						<th>Rue</th>
					</tr>';
			$req2=$db->prepare('select * from adresse WHERE organisation=?');
			$req2->execute(array($result['nom']));
			while($result2 = $req2->fetch(PDO::FETCH_ASSOC))
			{
				$display.='<tr>';
				$display.='<td><a href="index.php?page=adr/list&id='.$result2['pkArtif'].'">'. $result2['cp'].'</a></td>';
				$display.='<td><a href="index.php?page=adr/list&id='.$result2['pkArtif'].'">'.$result2['ville'].'</a></td>';
				$display.='<td><a href="index.php?page=adr/list&id='.$result2['pkArtif'].'">'.$result2['nom_rue'].'</td>';
				$display.='</tr>';
			}
		$display.='</table>';
		$req2->closeCursor();
		$req->closeCursor();
		}

	
		$displayAction.='<li><a href="index.php?page=firm/modify&id='.$result['nom'].'">Modifier le nom de l\'organisation</a></li>';
		$displayAction.='<li><a href="index.php?page=firm/creationAdr&id='.$result['nom'].'">Ajouter une adresse</a></li>';
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