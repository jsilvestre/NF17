<?php

$success = false;

if(!empty($_POST['submit'])) // si le formulaire a été validé
{
	// Récuperation des variables
	if(!empty($_POST['nom']) && !empty($_GET['id']))  //  <-----   LE PROBLEME DOIT ETRE ICI JE PENSE 
	{
		$nom=$_POST['nom'];
		$id=$_GET['id2'];
		$req=$db->prepare("select nom from organisation where nom=");
		$req->execute(array($nom));
			
		if($req->rowCount() == 0) // On teste si une organisation porte déjà le nom souhaité
		{
			// Création de la requete
			$req=$db->prepare("UPDATE organisation SET nom=? WHERE nom=?");
			// Exécution de la requete
			$req->execute(array($nom,$id));
			$req->closeCursor();
			
			// CHANGEMENT DANS ADRESSE
			$req=$db->prepare("select * from adresse WHERE organisation=?");
			// Exécution de la requete
			$req->execute(array($id));
					while( $result = $req->fetch(PDO::FETCH_ASSOC))
					{
					$req2=$db->prepare("UPDATE adresse SET organisation=? WHERE nom_rue=? AND cp=? and ville=?");
					$req2->execute(array($result['nom_rue'],$result['cp'],$result['ville']));
					$req2->closeCursor();
					}
			$req->closeCursor();
			header('Location: index.php?page=general/message&type=confirm&msg=L\'organisation '.$nom.' a bien été modifié.&retour=firm/list&opt=id='.$nom.'');
			$success = true;
		}
		else
		{
			$erreur = "Une organisation avec ce nom existe déjà dans la base de données.";
		}
		
	}
	else 
	{
		$erreur = "Un des champs n'a pas été rempli ou a été mal rempli.";
	}
}

if(!empty($_GET['id']))
{
	
	$id = $_GET['id'];
	
	$req=$db->prepare("select nom from organisation where nom=?");
	$req->execute(array($id));

	if($req->rowCount() == 0)
	{
		header("Location: index.php?page=general/message&type=error&msg=Organisation introuvable.&retour=firm/list");
	}
	else
	{		
		$erreur="";
	}
	
}
else
{
	if(!$success)
		header("Location: index.php?page=general/message&type=error&msg=Lien cassé. Veuillez en référer au responsable du site web.&retour=firm/list");
}


if(!empty($erreur))
{
	$erreur = '<p class="error">'.$erreur.'</p>';
}
else
{
	$erreur = "";
}

?>
<div id="wrapper">
	<div class="box">
		<h2>Fenêtre principale</h2>
		<?php echo $erreur; ?>
		<form method="post" action="index.php?page=firm/modify&id2="<?php echo $id;?>">
				<p> Nom de l'organisation : <input type="text" name="nom" value="<?php echo $id; ?>"/><br /><br />
				<input type="submit" value="Valider" name="submit" />
				</p>
		</form>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<li>Aucune action possible</li>
	</ul>
</div>
