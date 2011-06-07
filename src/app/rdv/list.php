<?php
function check_cancel($chaine) { return ($chaine == 0) ? "Maintenu" : "Annulé"; }

// initialisation des variables d'affichage
$display="";
$displayAction="";

if(!empty($_GET['id'])) // on affiche les informations du rendez-vous en question
{
	$id = $_GET['id'];
	$req=$db->prepare("select u.prenom as prenomU,u.nom as nomU,u.numSS as numSSU,c.prenom as prenomC,c.nom as nomC,c.numSS as numSSC,a.nom_rue,a.cp,a.ville,a.numero,r.annulation,r.date_heure,r.commentaire FROM rendezVous r, utilisateur u,contact c,organisation o,adresse a where r.pkArtif=? AND r.utilisateur=u.numSS AND c.numSS=r.contact AND c.organisation=o.nom AND a.organisation=o.nom");
	$req->execute(array($id));

	while($result = $req->fetch(PDO::FETCH_ASSOC))
	{
		$display.='Utilisateur : <a href="index.php?page=user/list&id='.$result['numSSU'].'">'.$result['prenomU'].' '.$result['nomU'].'</a><br />';
		$display.='Contact : <a href="index.php?page=contact/list&id='.$result['numSSC'].'">'.$result['prenomC'].' '.$result['nomC'].'</a><br />';
		$display.="Date : ".strftime('%d/%m/%Y à %R', strtotime($result['date_heure']))."</br>";
		$display.="Statut : ".check_cancel($result['annulation'])."<br />";
		$display.="Commentaire : ".$result['commentaire']."</br></br>";
		
		$display.="<b>Lieu</b> </br>";
		$display.="Numéro : ".$result['numero']."</br>";
		$display.="Nom de rue : ".$result['nom_rue']."</br>";
		$display.="Code postal : ".$result['cp']."</br>";
		$display.="Ville : ".$result['ville']."</br>";
	}

	$display.="<br /><a href=index.php?page=rdv/list>Retour</a>";
	
	// Affichage des actions possibles
	$displayAction.= "<li><a href=index.php?page=rdv/modify&id=".$id.">Modifier le rendez-vous</a></li>";
	$displayAction.= "<li><a href=index.php?page=rdv/delete&id=".$id.">Supprimer le rendez-vous (/!\ irréversible)</a></li>";
}
else // on affiche la liste des rendez-vous
{
	$req=$db->prepare("select u.prenom as prenomU,u.nom as nomU,u.numSS as numSSU,c.prenom as prenomC,c.nom as nomC,c.numSS as numSSC,o.nom as nomO,r.annulation,r.date_heure,r.pkArtif from rendezVous r,utilisateur u,contact c,organisation o where r.utilisateur=u.numSS AND c.numSS=r.contact AND o.nom=c.organisation ORDER BY date_heure DESC");
	$req->execute();
	
	$display.= '<table>
					<tr>
						<th>Date</th>
						<th>Utilisateur</th>
						<th>Contact</th>
						<th>Statut</th>
					</tr>';

	while($result = $req->fetch(PDO::FETCH_ASSOC))
	{
		$display.='<tr>';
		$display.='<td><a href="index.php?page=rdv/list&id='.$result['pkArtif'].'">'.strftime('%d/%m/%Y', strtotime($result['date_heure'])).' ('.strftime('%R', strtotime($result['date_heure'])).')</a></td>';
		$display.='<td><a href="index.php?page=user/list&id='.$result['numSSU'].'">'.$result['prenomU'].' '.$result['nomU'].'</a></td>';
		$display.='<td><a href="index.php?page=contact/list&id='.$result['numSSC'].'">'.$result['prenomC'].' '.$result['nomC'].' ('.$result['nomO'].')</td>';
		$display.="<td>".check_cancel($result['annulation'])."</td>";
		$display.='</tr>';
	}
	
	$display.='</table>';
	
	$req->closeCursor();


	$displayAction.= '<li><a href="index.php?page=rdv/creation">Création d\'un Rendez-vous</a></li>';
}
?>

<div id="wrapper">
	<div class="box">
		<h2>Liste des rendez-vous (du plus récent au plus ancien)</h2>
		<p> <?php echo $display; ?>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<?php echo $displayAction; ?>
	</ul>
</div>