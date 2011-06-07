<?php


if(!empty($_POST['submit']))
{
	if(!empty($_POST['nom']) && !empty($_POST['nom_rue']) && !empty($_POST['cp']) && !empty($_POST['ville']))
	{
		// Recuperation des variables
		$nom=$_POST['nom'];
		$rue=$_POST['nom_rue'];
		$cp=$_POST['cp'];
		$ville=$_POST['ville'];

		$req=$db->prepare("select * from organisation where nom=?");
		$req->execute(array($nom));
		if($req->rowCount() == 0)
		{
			// Creation de la requete
			$req=$db->prepare('INSERT INTO organisation VALUES(?)');
			// Execution de la requete
			$req->execute(array($nom));
			$req->closeCursor();

			$req=$db->prepare('INSERT INTO adresse (nom_rue,cp,ville,organisation) VALUES(?,?,?,?)');
			$req->execute(array($rue,$cp,$ville,$nom));
			$req->closeCursor();

			header('Location: index.php?page=general/message&type=confirm&msg=L\'organisation '.$nom.' a bien été créé.&retour=firm/creation');
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
		<form method="post" action="index.php?page=firm/creation">
		<p>
				Nom de l'organisation : <input type="text" name="nom" /> <BR>
				Nom de rue : <input type="text" name="nom_rue" /> <BR>
				Code postal: <input type="text" name="cp" /> <BR>
				Ville : <input type="text" name="ville" /> <BR>
				<input type="submit" value="Valider" name="submit" />
		</p>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<li><a href="index.php?page=firm/creation">Creation organisation</a></li>
	</ul>
</div>
