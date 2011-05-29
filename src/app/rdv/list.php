<?php
		$display="";
		$display2="";
		// En cas de premiere page, on affiche la liste des utilisateurs dans la base de données
		if(empty($_GET['id']))
		{
			$req=$db->prepare('SELECT login from utilisateur ORDER BY login');
			// Execution de la requete
			$req->execute();
			$display.="selectionnez l utilisateur dont vous voulez voir les rendez vous : </br>";
			while($result = $req->fetch(PDO::FETCH_ASSOC))
			{
				$display.= "<a href=index.php?page=rdv/list&id=".$result['login'].">".$result['login']."</a>";
				$display.="<BR>";
			}
			$req->closeCursor();
		// Affichage des actions possibles
			$display2.= "<li><a href=\"index.php?page=./rdv/creation\">Creation d'un Rendez-vous</a></li>";
		}
		else // Si un utilisateur a ete selectionne, on affiche la liste des informations le concernant
		{
		$id = $_GET['id'];
		$req=$db->prepare("select * from rendezVous r,adresse a where utilisateur=? AND r.lieu=a.id_adresse");
		$req->execute(array($id));
		
		while($result = $req->fetch(PDO::FETCH_ASSOC))
		{
		$display.="Date du rendez-vous : ".$result['date_heure']."</br>";
		// $display.="<p>  Heure du rendez vous : ".$result['']."</br>";
		$display.="Utilisateur concerné : ".$result['utilisateur']."</br>";
		$display.="Contact concerné : ".$result['contact']."</br>";
		$display.="Lieu : </br>";
			$display.="Nom de rue : ".$result['nom_rue']."</br>";
			$display.="Code postal : ".$result['cp']."</br>";
			$display.="Ville: ".$result['ville']."</br>";
		}
		
		$display.="<a href=index.php?page=rdv/list> Retour </a>";
		
		// Affichage des actions possibles
			$display2.= "<li><a href=index.php?page=./rdv/modif&id=".$id.">Modifier ce rendez-vous</a></li>";
			$display2.= "<li><a href=index.php?page=./rdv/suprim&id=".$id.">Supprimer ce rendez-vous</a></li>";
		}
	?>

<div id="wrapper">
	<div class="box">
		<h2>Accueil</h2>
		<p> <?php echo $display; ?>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<?php echo $display2; ?>
	</ul>
</div>