<?php

$success = false;

if(!empty($_POST['submit'])) // si le formulaire a été validé
{
	// Récuperation des variables
	if(!empty($_POST['cp']) && !empty($_POST['ville']) && !empty($_POST['rue']) && !empty($_POST['nom']) && !empty($_POST['num']))  //  <-----   LE PROBLEME DOIT ETRE ICI JE PENSE 
	{
		$num=$_POST['num'];
		$rue=$_POST['rue'];
		$ville=$_POST['ville'];
		$cp=$_POST['cp'];
		$nom=$_POST['nom'];
		
		$req=$db->prepare("select * from adresse where nom_rue=? AND cp=? AND ville=? AND numero=?");
		$req->execute(array($rue,$cp,$ville,$num));
		if ($req->rowCount()==0)
		{
			// Création de la requete
			$req=$db->prepare('INSERT INTO adresse (nom_rue,cp,ville,organisation,numero) VALUES(?,?,?,?,?)');
			$req->execute(array($rue,$cp,$ville,$nom,$num));
			// Exécution de la requete
			$req->closeCursor();
				
			header('Location: index.php?page=general/message&type=confirm&msg=L\'adresse a bien été créé.&retour=firm/list');
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
else if (!empty($_GET['id']))
{
	$nom=$_GET['id'];
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
		<form method="post" action="index.php?page=firm/creationAdr">
				<p> Numero : <input type="text" name="num"/> <br />
				Rue : <input type="text" name="rue"/> <br /> <input type="hidden" name="nom" value="<?php echo $nom; ?>"/>
				code postal : <input type="text" name="cp"/> <br />
				Ville : <input type="text" name="ville"/> <br /><br />
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
