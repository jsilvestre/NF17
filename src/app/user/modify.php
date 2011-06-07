<?php

$success = false;

if(!empty($_POST['submit'])) // si le formulaire a été validé
{
	// Récuperation des variables
	if(!empty($_POST['login']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['jour']) && !empty($_POST['mois']) && 
		!empty($_POST['an']) && !empty($_POST['mdp']) && !empty($_POST['numSS']))
	{
		$login=$_POST['login'];
		$nom=$_POST['nom'];
		$prenom=$_POST['prenom'];
		$jour=$_POST['jour'];
		$mois=$_POST['mois'];
		$an=$_POST['an'];
		$numSS=$_POST['numSS'];
		$mdp=$_POST['mdp'];
	
		$is_special = (!empty($_POST['is_special']) && $_POST['is_special'] == "on") ? 1 : 0;

		if(checkdate((int)$mois, (int)$jour, (int)$an) == true)
		{
			// Création de la date
			$date=$an.'-'.$mois.'-'.$jour;
			$req=$db->prepare("select * from utilisateur where numSS=? AND login=?");
			$req->execute(array($numSS,$login));
			$result = $req->fetch(PDO::FETCH_ASSOC);
			
			if($req->rowCount() == 1)
			{
				// Création de la requete
				$req=$db->prepare("UPDATE utilisateur SET login=?,nom=?,prenom=?,dateNaissance=?,mdp=?,is_special=? WHERE numSS=?");
				// Exécution de la requete
				$req->execute(array($login,$nom,$prenom,$date,$mdp,$is_special,$numSS));
				$req->closeCursor();
				
				header('Location: index.php?page=general/message&type=confirm&msg=L\'utilisateur '.$login.' a bien été modifié.&retour=user/list&opt=id='.$numSS.'');
				$success = true;
			}
			else
			{
				$erreur = "Un utilisateur avec ce login ou ce numéro de sécurité sociale existe déjà dans la base de données.";
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
	
	$req=$db->prepare("select numSS from utilisateur where numSS=?");
	$req->execute(array($id));

	if($req->rowCount() == 0)
	{
		header("Location: index.php?page=general/message&type=error&msg=Utilisateur introuvable.&retour=user/list");
	}
	else
	{
		$req=$db->prepare("SELECT * FROM utilisateur WHERE numSS=?");
		$req->execute(array($id));
		$result = $req->fetch(PDO::FETCH_ASSOC);
		
		$is_special = ($result['is_special'] == 1) ? 'checked="checked"' : '';
		$timestamp = strtotime($result['dateNaissance']);
		$jour = date("d",$timestamp);
		$mois = date("m",$timestamp);
		$an = date("Y",$timestamp);
	}
}
else
{
	if(!$success)
		header("Location: index.php?page=general/message&type=error&msg=Lien cassé. Veuillez en référer au responsable du site web.&retour=user/list");
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
		<form method="post" action="index.php?page=user/modify">
				<p>Nom d'utilisateur : <input type="text" name="login" value="<?php echo $result['login']; ?>"/><br />
				Nom: <input type="text" name="nom" value="<?php echo $result['nom']; ?>"/><br />
				Prénom : <input type="text" name="prenom" value="<?php echo $result['prenom']; ?>" /><br />
				Date de naissance (JJ MM AAAA): <input type="text" name="jour" value="<?php echo $jour; ?>"/> - 
												<input type="text" name="mois" value="<?php echo $mois; ?>" /> - 
												<input type="text" name="an" value="<?php echo $an; ?>"/><br />
				Numéro de sécurité sociale : <?php echo $result['numSS']; ?><input type="hidden" name="numSS" value="<?php echo $result['numSS']; ?>" /><br />
				Mot de passe : <input type="password" name="mdp" value="<?php echo $result['mdp']; ?>"/><br />
				Administrateur : <input type="checkbox" name="is_special" <?php echo $is_special;?>/><br />
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
