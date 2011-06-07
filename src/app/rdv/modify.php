<?php

// initialisation des variables de sorties
$display="";
$erreur="";

if(!empty($_POST['submit']))
{
		if(!empty($_POST['user']) && !empty($_POST['jour']) && !empty($_POST['mois']) && !empty($_POST['an']) && !empty($_POST['heure']) && 
		!empty($_POST['min']) && !empty($_POST['contact']) && !empty($_POST['adresse']) && !empty($_POST['commentaire']) && !empty($_POST['id']))
		{
			// Recuperation des variables
			$id = $_POST['id'];
			$jour=$_POST['jour'];
			$mois=$_POST['mois'];
			$an=$_POST['an'];
			$heure=$_POST['heure'];
			$min=$_POST['min'];
			$user=$_POST['user'];
			$contact=$_POST['contact'];
			$adresse=$_POST['adresse'];
			$commentaire=$_POST['commentaire'];
			
			
			if(checkdate((int)$mois, (int)$jour, (int)$an) == true)
			{
				// Creation de la date du rendez vous
				$date=$an.'-'.$mois.'-'.$jour.' '.$heure.':'.$min.':'.'00' ;
				// Creation du rendez vous
				$req=$db->prepare("UPDATE rendezVous SET date_heure=?, utilisateur=?, contact=?, lieu=?, commentaire=? WHERE pkArtif=?");
				// Execution de la requete
				$req->execute(array($date,$user,$contact,$adresse,$commentaire,$id));
				$req->closeCursor();
				header('Location: index.php?page=general/message&type=confirm&msg=Le rendez vous a bien été modifié.&retour=rdv/list');
			}
			else
			{
				$erreur.= "<p>La date spécifiée n'est pas valide.</p>";
			}
		}
		else 
		{
			$erreur .= "<p>Un des champs n'a pas été rempli ou a été mal rempli.</p>";
		}
	
}

if(empty($_POST['submit']) || !empty($erreur)) // Si le formulaire n'a pas deja soumis ou s'il y a eu une erreur dans sa soumission
{
	if(!empty($_GET['id']) || !empty($_POST['id']))
	{		
		$id = (empty($_GET['id'])) ? $_POST['id'] : $_GET['id'];
		
		$req = $db->prepare("SELECT * FROM rendezVous WHERE pkArtif=?");
		$req->execute(array($id));
		if($req->rowCount() == 0)
		{
			header("Location: index.php?page=general/message&type=error&msg=Rendez-vous introuvable.&retour=user/list");
		}
		else
		{
			$rdv = $req->fetch(PDO::FETCH_ASSOC);
			
			$jour = strftime('%d', strtotime($rdv['date_heure']));
			$mois = strftime('%m', strtotime($rdv['date_heure']));
			$an = strftime('%Y', strtotime($rdv['date_heure']));
			$heure = strftime('%H', strtotime($rdv['date_heure']));
			$minute = strftime('%M', strtotime($rdv['date_heure']));
			$user = $rdv['utilisateur'];
			$contact = $rdv['contact'];
			$adresse = $rdv['lieu'];
			echo $adresse;
			$commentaire = $rdv['commentaire'];
		
			$display.="<form method=\"post\" action=\"index.php?page=rdv/modify\">";
			$display.="<p>Date du rendez-vous (JJ MM AAAA): <input type=\"text\" name=\"jour\" value=\"".$jour."\" /> - <input type=\"text\" name=\"mois\" value=\"".$mois."\" /> - <input type=\"text\" name=\"an\" value=\"".$an."\"/><br />";
			$display.="Heure du rendez vous : <input type=\"text\" name=\"heure\" value=\"".$heure."\"/> : <input type=\"text\" name=\"min\" value=\"".$minute."\" /><br />";
			$display.="Utilisateur concerné : ";
			// Menu deroulant pour la liste des utilisateur
			$display.= '<select name="user">';

			$req=$db->prepare('SELECT nom,prenom,login,numSS from utilisateur ORDER BY nom');
			// Execution de la requete
			$req->execute();
			while($result = $req->fetch(PDO::FETCH_ASSOC)) {
				$selected = ($result['numSS'] == $user) ? 'selected' : '';			
				$display.= '<option value="'.$result['numSS'].'" '.$selected.'>'. $result['nom'].' '.$result['prenom'].' ('.$result['login'].')</option>';
			}
			$display.="</select>";
			$display.="<br />";
			// Menu deroulant pour la liste des contact
			$display.="Contact concerné : ";
			$display.= '<select name="contact">';

			$req=$db->prepare('SELECT nom,prenom,numSS from contact ORDER BY nom');
			// Execution de la requete
			$req->execute();
			while($result = $req->fetch(PDO::FETCH_ASSOC)) {
				$selected = ($result['numSS'] == $contact) ? 'selected' : '';
				$display.= '<option value="'.$result['numSS'].'" '.$selected.'>'.$result['nom'].' '.$result['prenom'].'</option>';
			}
			$display.="</select>";
			$display.="<br />";
			$display.="Lieu : ";
			$display.= '<select name="adresse">';

			$req=$db->prepare('SELECT * from adresse ORDER BY organisation');
			// Execution de la requete
			$req->execute();
			while($result = $req->fetch(PDO::FETCH_ASSOC)) {
				$selected = ($result['pkArtif'] == $adresse) ? 'selected' : '';						
				$display.= '<option value="'.$result['pkArtif'].'" '.$selected.'>n°'.$result['numero'].', '.$result['nom_rue'].', '.$result['cp'].' '.$result['ville'].' ('.$result['organisation'].')</option>';
			}
			$display.="</select>";
			$display.="<br />";
									
			$display.='Commentaire : </br>';
			$display.='<textarea name="commentaire" wrap="physical" align="center">'.$commentaire.'</textarea><br />';
			$display.="<input type=\"submit\" value=\"Valider\" name=\"submit\" /><input type=\"hidden\" name=\"id\" value=\"".$id."\"/></form>";
			$display.="</p> </br>";
			$display.="<a href=index.php?page=rdv/list>Retour</a>";
		}
	}
	else
	{
		// header ...
	}
}
?>
<div id="wrapper">
	<div class="box">
		<h2>Fenêtre principale</h2>
		<?php echo $erreur.$display; ?>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<p>Aucune action possible...</p>
</div>