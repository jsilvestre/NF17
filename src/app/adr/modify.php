<?php

$success = false;

if(!empty($_POST['submit'])) // si le formulaire a été validé
{
	// Récuperation des variables
	if(!empty($_POST['rue']) && !empty($_POST['key']) && !empty($_POST['ville']) && !empty($_POST['cp']))
	{
		$key=$_POST['key'];
		$cp=$_POST['cp'];
		$ville=$_POST['ville'];
		$rue=$_POST['rue'];

		$req=$db->prepare("select * from adresse where cp=? AND nom_rue=? AND ville=?");
		$req->execute(array($cp,$rue,$ville));	
		
		if($req->rowCount() == 0)
		{
			// Création de la requete
			$req=$db->prepare("UPDATE adresse SET nom_rue=?,cp=?,ville=? WHERE pkArtif=?");
			// Exécution de la requete
			$req->execute(array($rue,$cp,$ville,$key));
			$req->closeCursor();
				
			header('Location: index.php?page=general/message&type=confirm&msg=L\'adresse a bien été modifié.&retour=firm/list');
			$success = true;
		}
		else
		{
			$erreur = "Cette adresse existe déjà dans la base de données.";
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
	
	$req=$db->prepare("select * from adresse where pkArtif=?");
	$req->execute(array($id));

	if($req->rowCount() == 0)
	{
		header("Location: index.php?page=general/message&type=error&msg=Adresse introuvable.&retour=firm/list");
	}
	else
	{
	$result = $req->fetch(PDO::FETCH_ASSOC);
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
		<form method="post" action="index.php?page=adr/modify">
				<p>Code postal : <input type="text" name="cp" value="<?php echo $result['cp']; ?>"/><br />  <input type="hidden" name="key" value="<?php echo $result['pkArtif']; ?>"/>
				Ville : <input type="text" name="ville" value="<?php echo $result['ville']; ?>" /><br />
				Nom de rue : <input type="text" name="rue" value="<?php echo $result['nom_rue']; ?>"/><br />
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
