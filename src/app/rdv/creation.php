<?php

// initialisation des variables de sorties
$display="";
$erreur="";

if(!empty($_POST['submit']))
{
		if(!empty($_POST['user']) && !empty($_POST['jour']) && !empty($_POST['mois']) && !empty($_POST['an']) && !empty($_POST['heure']) && 
		!empty($_POST['min']) && !empty($_POST['contact']) && !empty($_POST['adresse']) && !empty($_POST['commentaire']))
		{
			// Recuperation des variables
			$jour=$_POST['jour'];
			$mois=$_POST['mois'];
			$an=$_POST['an'];
			$heure=$_POST['heure'];
			$min=$_POST['min'];
			$user=$_POST['user'];
			$contact=$_POST['contact'];
			$adresse=$_POST['adresse'];
			$commentaire=$_POST['commentaire'];
			
			// Creation de la date du rendez vous
			$date=$an.'-'.$mois.'-'.$jour.' '.$heure.':'.$min.':'.'00' ;
			
			// Creation du rendez vous
			$req=$db->prepare("INSERT INTO rendezVous(date_heure,utilisateur,contact,annulation,lieu,commentaire) VALUES(?,?,?,?,?,?)");
			// Execution de la requete
			$req->execute(array($date,$user,$contact,0,$adresse,$commentaire));
			$req->closeCursor();
			header('Location: index.php?page=general/message&type=confirm&msg=Le rendez vous a bien été créé.&retour=rdv/list');
		}
		else 
		{
			$erreur .= "<p>Un des champs n'a pas été rempli ou a été mal rempli.</p>";
		}
	
}

if(empty($_POST['submit']) || !empty($erreur)) // Si le formulaire n'a pas deja ete rempli
{
		$display.="<form method=\"post\" action=\"index.php?page=rdv/creation\">";
		$display.="<p>Date du rendez-vous (JJ MM AAAA): <input type=\"text\" name=\"jour\" /> - <input type=\"text\" name=\"mois\" /> - <input type=\"text\" name=\"an\" /> <BR>";
		$display.="Heure du rendez vous : <input type=\"text\" name=\"heure\" /> : <input type=\"text\" name=\"min\" /><BR>";
		$display.="Utilisateur concerné : ";
		// Menu deroulant pour la liste des utilisateur
		$display.= '<select name="user"><option value="" selected></option>';

		$req=$db->prepare('SELECT nom,prenom,login,numSS from utilisateur ORDER BY nom');
		// Execution de la requete
		$req->execute();
		while($result = $req->fetch(PDO::FETCH_ASSOC)) {			
			$display.= '<option value="'.$result['numSS'].'">'. $result['nom'].' '.$result['prenom'].' ('.$result['login'].')</option>';
		}
		$display.="</select>";
		$display.="<br />";
		// Menu deroulant pour la liste des contact
		$display.="Contact concerné : ";
		$display.= '<select name="contact"><option value="" selected></option>';

		$req=$db->prepare('SELECT nom,prenom,numSS from contact ORDER BY nom');
		// Execution de la requete
		$req->execute();
		while($result = $req->fetch(PDO::FETCH_ASSOC)) {			
			$display.= '<option value="'.$result['numSS'].'">'.$result['nom'].' '.$result['prenom'].'</option>';
		}
		$display.="</select>";
		$display.="<br />";
		$display.="Lieu : ";
		$display.= '<select name="adresse"><option value="" selected></option>';

		$req=$db->prepare('SELECT * from adresse ORDER BY organisation');
		// Execution de la requete
		$req->execute();
		while($result = $req->fetch(PDO::FETCH_ASSOC)) {			
			$display.= '<option value="'.$result['pkArtif'].'">n°'.$result['numero'].', '.$result['nom_rue'].', '.$result['cp'].' '.$result['ville'].' ('.$result['organisation'].')</option>';
		}
		$display.="</select>";
		$display.="<br />";
									
		$display.='Commentaire : </br>';
		$display.='<textarea name="commentaire" wrap="physical" align="center">Commentez ici</textarea><br />';
		$display.="<input type=\"submit\" value=\"Valider\" name=\"submit\" />";
		$display.="</p> </br>";
		$display.="<a href=index.php?page=rdv/list>Retour</a>";
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