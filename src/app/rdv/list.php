<?php
		$display="";
		$display2="";
		// En cas de premiere page, on affiche la liste des utilisateurs dans la base de données
		if(empty($_GET['id']))
		{
			$req=$db->prepare('SELECT identifiant from contact');
			// Execution de la requete
			$req->execute();
			while($result = $req->fetch(PDO::FETCH_ASSOC))
			{
				$display.= "<a href=index.php?page=./contact/list&id=".$result['identifiant'].">".$result['identifiant']."</a>";
				$display.="<BR>";
			}
			$req->closeCursor();
			
		// Affichage des actions possibles
			$display2.= "<li><a href=\"index.php?page=./rdv/creation\">Creation d'un Rendez-vous</a></li>";
			$display2.= "<li><a href=\"index.php?page=./rdv/modif\">Modification d'un rendez-vous (A FAIRE)</a></li>";
			$display2.= "<li><a href=\"index.php?page=./rdv/supprim\">Suppression d'un contact(A FAIRE)</a></li>";
		}
		else // Si un utilisateur a ete selectionne, on affiche la liste des informations le concernant
		{
		$id = $_GET['id'];
		$req=$db->prepare("select * from contact where identifiant=?");
		$req->execute(array($id));
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$display.="nom d utilisateur : ".$result['identifiant']."<BR>" ;
		$display.="nom  : ".$result['nom']."<BR>" ;
		$display.="Prenom : ".$result['prenom']."<BR>" ;
		$display.="Date de naissance : ".$result['dateNaissance']."<BR>" ;
		$display.="Numero de securite sociale : ".$result['numSS']."<BR> <BR><BR><BR>" ;
		
		$display.="<a href=index.php?page=./rdv/list> Retour </a>";
		
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