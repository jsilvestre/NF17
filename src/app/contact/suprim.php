		<?php
		$display="";
			if ( empty($_GET['id']))
			{
			// CREATION DU FORMULAIRE DE CHOIX
			$display.= "<form method=\"post\" action=\"index.php?page=./contact/modif\">";
			$display.= "Numero d'identification du contact à modifier : ";
			$display.= "<select name=\"id\">";
			
			// CREATION DE LA REQUETE
			$req=$db->prepare('SELECT identifiant FROM contact');
			// Execution de la requete
			$req->execute();
			
			// INSERTION DES LIGNES DANS LE FORMULAIRE
				while($result = $req->fetch(PDO::FETCH_ASSOC)) {			
					$display.= "<option value=".$result['identifiant'].">". $result['identifiant']."</option>";
				}
			$display.= "</select>	";
			$display.= "<BR/>";
			$display.= "<input type=\"submit\" value=\"Valider\" name=\"submit\"/>";
		}
		else
		{
		$id=$_GET['id'];
		
		$req=$db->prepare("delete from contact where identifiant=?");
		$req->execute(array($id));
		$display.= "Contact supprimé <BR><BR>";
		$display.="<a href=index.php?page=./contact/list> Retour </a>";
		}
		?>

<div id="wrapper">
	<div class="box">
		<h2>Accueil</h2>
		<p> <?php echo $display; ?>
		</p>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<li><a href="index.php?page=./contact/creation">Creation d'un contact</a></li>
		<li><a href="index.php?page=./contact/modif">modification d'un contact</a></li>
		<li><a href="index.php?page=./contact/supprim">Suppression d'un contact</a></li>
	</ul>
</div>