<?php

$display="";
if(!empty($_POST['submit']))
{
		if(!empty($_POST['user']) && !empty($_POST['jour']) && !empty($_POST['mois']) && !empty($_POST['an']) && !empty($_POST['heure']) && 
		!empty($_POST['min']) && !empty($_POST['contact']) && !empty($_POST['rue']) && !empty($_POST['cp']) && !empty($_POST['ville']) && !empty($_POST['firm']))
		{
			// Recuperation des variables
			$jour=$_POST['jour'];
			$mois=$_POST['mois'];
			$an=$_POST['an'];
			$heure=$_POST['heure'];
			$min=$_POST['min'];
			$user=$_POST['user'];
			$contact=$_POST['contact'];
			$rue=$_POST['rue'];
			$cp=$_POST['cp'];
			$ville=$_POST['ville'];
			$firm=$_POST['firm'];
			
			// Creation de la date du rendez vous
			$date=$an.'-'.$mois.'-'.$jour.' '.$heure.':'.$min.':'.'00' ;
			
			// test pour savoir si l'adresse existe
			$req=$db->prepare('select * from adresse WHERE nom_rue=? AND CP=? AND VILLE=? AND organisation=?');
			// Execution de la requete
			$req->execute(array($rue,$cp,$ville,$firm));
			if ($req->rowCount()==1) // Si l'adresse existe deja, on ne la recrée pas
			{
				$result = $req->fetch(PDO::FETCH_ASSOC);
				// Creation du rendez vous
				$req=$db->prepare('INSERT INTO rendezVous VALUES(?,?,?,?,?)');
				// Execution de la requete
				$req->execute(array($date,$user,$contact,0,$result['pkArtif']));
				$req->closeCursor();
			}
			else // Creation de l'adresse puis du rendez vous
			{	
				// Creation de l'adresse
				$req=$db->prepare('INSERT INTO adresse (nom_rue,cp,ville,organisation) VALUES(?,?,?,?)');
				// Execution de la requete
				$req->execute(array($rue,$cp,$ville,$firm));
				$req->closeCursor();

				// Recuperation de la clé de l'adresse
				$req=$db->prepare('select pkArtif from adresse WHERE nom_rue=? AND CP=? AND VILLE=? AND organisation=?');
				// Execution de la requete
				$req->execute(array($rue,$cp,$ville,$firm));
				$result = $req->fetch(PDO::FETCH_ASSOC);
				
				// Creation du rendez vous
				$req2=$db->prepare('INSERT INTO rendezVous VALUES(?,?,?,?,?)');
				// Execution de la requete
				$req2->execute(array($date,$user,$contact,0,$result['pkArtif']));
				$req2->closeCursor();
				$req->closeCursor();
			}
		header('Location: index.php?page=general/message&type=confirm&msg=Le rendez vous a bien été créé.&retour=rdv/creation');
		}
		else 
		{
			$erreur = "Un des champs n'a pas été rempli ou a été mal rempli.";
		}
	
}
else // Si le formulaire n'a pas deja ete rempli
{
		$display.="<form method=\"post\" action=\"index.php?page=rdv/creation\">";
		$display.="Date du rendez-vous (JJ MM AAAA): <input type=\"text\" name=\"jour\" /> - <input type=\"text\" name=\"mois\" /> - <input type=\"text\" name=\"an\" /> <BR>";
		$display.="<p>  Heure du rendez vous : <input type=\"text\" name=\"heure\" /> : <input type=\"text\" name=\"min\" /><BR>";
		$display.="Utilisateur concerné : ";
		// Menu deroulant pour la liste des utilisateur
		$display.= "<select name=\"user\">";

		$req=$db->prepare('SELECT login,numSS from utilisateur');
		// Execution de la requete
		$req->execute();
		while($result = $req->fetch(PDO::FETCH_ASSOC)) {			
		$display.= "<option value=".$result['numSS'].">". $result['login']."</option>";
		}
		$display.="</select>";
		$display.="<BR>";
		// Menu deroulant pour la liste des contact
		$display.="Contact concerné : ";
		$display.= "<select name=\"contact\">";

		$req=$db->prepare('SELECT nom, prenom,numSS from contact');
		// Execution de la requete
		$req->execute();
		while($result = $req->fetch(PDO::FETCH_ASSOC)) {			
		$display.= "<option value=".$result['numSS'].">". $result['nom']. $result['prenom']."</option>";
		}
		$display.="</select>";
		$display.="<BR>";
		$display.="Lieu :</br>";
		// ADRESSE
				$display.="  Nom de rue : <input type=\"text\" name=\"rue\" /></br>";
				$display.="  Code postal : <input type=\"text\" name=\"cp\" /></br>";
				$display.="  Ville: <input type=\"text\" name=\"ville\" /></br>"; 
				$display.="  Organisation : <input type=\"text\" name=\"firm\" /></br>";
									
		$display.='Commentaire : </br>';
		$display.='<textarea name="mon_champ" wrap="physical" align="center">Commentez ici</textarea><BR>';
		$display.="<input type=\"submit\" value=\"Valider\" name=\"submit\" />";
		$display.="</p> </br></br></br>";
		$display.="<a href=index.php?page=./rdv/list> Retour </a>";
}
?>



<div id="wrapper">
	<div class="box">
		<h2>Fenêtre principale</h2>
		<?php echo $display; ?>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
	</ul>
</div>