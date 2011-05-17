<?php

$display="";
if(!empty($_POST['submit']))
{
		// Recuperation des variables
		$jour=$_POST['jour'];
		$mois=$_POST['mois'];
		$an=$_POST['an'];
		$heure=$_POST['heure'];
		$min=$_POST['min'];
		$user=$_POST['user'];
		$contact=$_POST['contact'];
		$lieu=$_POST['lieu'];
		
		// Creation de la date du rendez vous
		$date=$an.'-'.$mois.'-'.$jour.' '.$heure.':'.$min.':'.'00' ;
		// Creation de la requete
		$req=$db->prepare('INSERT INTO rendezVous VALUES(?,?,?,?,?)');
		// Execution de la requete
		$req->execute(array($date,$user,$contact,0,$lieu));
		$req->closeCursor();

}
else // Si le formulaire n'a pas deja ete rempli
{
		$display.="<form method=\"post\" action=\"index.php?page=rdv/creation\">";
		$display.="Date du rendez-vous (JJ MM AAAA): <input type=\"text\" name=\"jour\" /> - <input type=\"text\" name=\"mois\" /> - <input type=\"text\" name=\"an\" /> <BR>";
		$display.="<p>  Heure du rendez vous : <input type=\"text\" name=\"heure\" /> - <input type=\"text\" name=\"min\" /><BR>";
		$display.="Utilisateur concern� : ";
		// Menu deroulant pour la liste des utilisateur
		$display.= "<select name=\"user\">";

		$req=$db->prepare('SELECT login from utilisateur');
		// Execution de la requete
		$req->execute();
		while($result = $req->fetch(PDO::FETCH_ASSOC)) {			
		$display.= "<option value=".$result['login'].">". $result['login']."</option>";
		}
		$display.="</select>";
		$display.="<BR>";
		// Menu deroulant pour la liste des contact
		$display.="Contact concern� : ";
		$display.= "<select name=\"contact\">";

		$req=$db->prepare('SELECT identifiant from contact');
		// Execution de la requete
		$req->execute();
		while($result = $req->fetch(PDO::FETCH_ASSOC)) {			
		$display.= "<option value=".$result['identifiant'].">". $result['identifiant']."</option>";
		}
		$display.="</select>";
		$display.="<BR>";
		$display.="Lieu : <input type=\"text\" name=\"lieu\" /><BR>";
		$display.="<input type=\"submit\" value=\"Valider\" name=\"submit\" />";
		$display.="</p>";
}
?>



<div id="wrapper">
	<div class="box">
		<h2>Fen�tre principale</h2>
		<?php echo $display; ?>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<li><a href="index.php?page=./user/creation">Creation utilisateur</a></li>
	</ul>
</div>