<div id="wrapper">
	<div class="box">
		<h2>Accueil</h2>
		<?php
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=nf17', 'root', '', $pdo_options);
		// En cas de premiere page, on affiche la liste des utilisateurs dans la base de données
		if(empty($_GET['id']))
		{
			$req=$bdd->prepare('SELECT identifiant from contact');
			// Execution de la requete
			$req->execute();
			while($result = $req->fetch(PDO::FETCH_ASSOC))
			{
				echo "<a href=index.php?page=./contact/list&id=",$result['identifiant'],">",$result['identifiant'],"</a>";
				echo "<BR>";
			}
			$req->closeCursor();
		}
		else // Si un utilisateur a ete selectionne, on affiche la liste des informations le concernant
		{
		$req=$bdd->prepare("select * from contact where identifiant=?");
		$req->execute(array($_GET['id']));
		$result = $req->fetch(PDO::FETCH_ASSOC);
		echo "nom d utilisateur : ",$result['identifiant'],"<BR>" ;
		echo "nom  : ",$result['nom'],"<BR>" ;
		echo "Prenom : ",$result['prenom'],"<BR>" ;
		echo "Date de naissance : ",$result['dateNaissance'],"<BR>" ;
		echo "Numero de securite sociale : ",$result['numSS'],"<BR> <BR><BR><BR>" ;
		
		echo "<a href=index.php?page=./contact/list> Retour </a>";
		}
	?>
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