<?php
if(!empty($_POST['submit'])) // si le formulaire a été validé
{
	// Récuperation des variables
	if(!empty($_POST['ville']) && !empty($_POST['cp']) && !empty($_POST['rue']) && !empty($_POST['firm']))
	{
		$ville=$_POST['ville'];
		$cp=$_POST['cp'];
		$rue=$_POST['rue'];
		$firm=$_POST['firm'];
		

		$req=$db->prepare("select * from adresse where cp=? AND ville=? AND nom_rue=?");
		$req->execute(array($cp,$ville,$rue));
		if($req->rowCount() == 0)
		{
			// Création de la requete
			$req=$db->prepare('INSERT INTO adresse (nom_rue,cp,ville,organisation) VALUES(?,?,?,?)');
			// Exécution de la requete
			$req->execute(array($rue,$cp,$ville,$firm));
			$req->closeCursor();
				
			header('Location: index.php?page=general/message&type=confirm&msg=L\'adresse a bien été créé.&retour=firm/list');
		}
		else
		{
			$erreur = "Un utilisateur avec ce login ou ce numéro de sécurité sociale existe déjà dans la base de données.";
		}
		$req->closeCursor();
	}
	else 
	{
		$erreur = "Un des champs n'a pas été rempli ou a été mal rempli.";
	}
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
		<form method="post" action="index.php?page=user/creation">
				<p>Rue : <input type="text" name="rue" /><br />  <input type="hidden" name="rue" value="<?php echo $_GET['id']; ?>"/><br /> 
				Ville : <input type="text" name="cp" /><br />
				Code postal : <input type="text" name="ville" /><br />
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
