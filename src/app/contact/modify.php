<?php

$success = false;

if(!empty($_POST['submit'])) // si le formulaire a été validé
{
	// Récuperation des variables
	if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['jour']) && !empty($_POST['mois']) && 
		!empty($_POST['an']) && !empty($_POST['firm']) && !empty($_POST['numSS']) && !empty($_POST['poste']))
	{
		$nom=$_POST['nom'];
		$prenom=$_POST['prenom'];
		$jour=$_POST['jour'];
		$mois=$_POST['mois'];
		$an=$_POST['an'];
		$numSS=$_POST['numSS'];
		$poste=$_POST['poste'];
		$firm=$_POST['firm']; 	

		if(is_integer((int)$mois) && is_integer((int)$jour) && is_integer((int)$an) && checkdate($mois, $jour, $an) == true)
		{
			// Création de la date
			$date=$an.'-'.$mois.'-'.$jour;
			$req=$db->prepare("select * from contact where numSS=?");
			$req->execute(array($numSS));
			$result = $req->fetch(PDO::FETCH_ASSOC);
			
			if($req->rowCount() == 1)
			{
				// Création de la requete
				$req=$db->prepare("UPDATE contact SET nom=?,prenom=?,dateNaissance=?,organisation=?,poste=? WHERE numSS=?");
				// Exécution de la requete
				$req->execute(array($nom,$prenom,$date,$firm,$poste,$numSS));
				$req->closeCursor();
				
				// Création de la requete
				$req=$db->prepare("select * from organisation where nom=?");
				// Exécution de la requete
				$req->execute(array($firm));
					if($req->rowCount() == 0)
					{
					$req2=$db->prepare("INSERT INTO organisation VALUES(?)");
					$req2->execute(array($firm));
					$req2->CloseCursor();
					}
				$req->closeCursor();
				header('Location: index.php?page=general/message&type=confirm&msg=Le contact '.$nom.' a bien été modifié.&retour=contact/modify&opt=id='.$numSS.'');
				$success = true;
			}
			else
			{
				$erreur = "Un contact avec ce nom ou ce numéro de sécurité sociale existe déjà dans la base de données.";
			}
		}
		else
		{
			$erreur = "Il y a une erreur de saisie dans la date.";
		}
	}
	else 
	{
		$erreur = "Un des champs n'a pas été rempli ou a été mal rempli.";
	}
}

if(!empty($_GET['id']) || !empty($_POST['numSS']))
{
	
	$id = (empty($_GET['id'])) ? $_POST['numSS'] : $_GET['id'];
	
	$req=$db->prepare("select numSS from contact where numSS=?");
	$req->execute(array($id));

	if($req->rowCount() == 0)
	{
		header("Location: index.php?page=general/message&type=error&msg=Contact introuvable.&retour=contact/list");
	}
	else
	{
		$req=$db->prepare("SELECT * FROM contact WHERE numSS=?");
		$req->execute(array($_GET['id']));
		$result = $req->fetch(PDO::FETCH_ASSOC);
		
		$jour = 1;
		$mois = 2;
		$an = 3;
	}

}
else
{
	if(!$success)
		header("Location: index.php?page=general/message&type=error&msg=Lien cassé. Veuillez en référer au responsable du site web.&retour=contact/list");
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
		<form method="post" action="index.php?page=contact/modify">
				<p>
				Nom: <input type="text" name="nom" value="<?php echo $result['nom']; ?>"/><br />
				Prénom : <input type="text" name="prenom" value="<?php echo $result['prenom']; ?>" /><br />
				Date de naissance (JJ MM AAAA): <input type="text" name="jour" value="<?php echo $jour; ?>"/> - 
												<input type="text" name="mois" value="<?php echo $mois; ?>" /> - 
												<input type="text" name="an" value="<?php echo $an; ?>"/><br />
				Numéro de sécurité sociale : <?php echo $result['numSS']; ?><input type="hidden" name="numSS" value="<?php echo $result['numSS']; ?>" /><br />
				Organisation : <input type="text" name="firm" value="<?php echo $result['organisation']; ?>"/><br />
				Poste : <input type="texte" name="poste" value="<?php echo $result['poste']; ?>"/><br /><br />
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