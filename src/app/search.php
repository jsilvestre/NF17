<?php

function check_cancel($chaine) { return ($chaine == 0) ? "Maintenu" : "Annulé"; }

$display="";
$displayAction="Aucune action possible";
		
if(!empty($_POST['userSearch']))
{
	if(empty($_POST['nomUser'])) {
		if(!empty($_POST['prenomUser']))
		{
			$sql = "select u.prenom as prenomU,u.nom as nomU,u.numSS as numSSU,c.prenom as prenomC,c.nom as nomC,c.numSS as numSSC,o.nom as nomO,r.annulation,r.date_heure,r.pkArtif from rendezVous r,utilisateur u,contact c,organisation o WHERE r.utilisateur IN (SELECT numSS FROM utilisateur WHERE prenom LIKE ?) AND r.utilisateur=u.numSS AND c.numSS=r.contact AND o.nom=c.organisation ORDER BY date_heure DESC";
			$val = array('%'.$_POST['prenomUser'].'%');
		}
	}
	else
	{
		if(!empty($_POST['prenomUser']))
		{
			$sql = "select u.prenom as prenomU,u.nom as nomU,u.numSS as numSSU,c.prenom as prenomC,c.nom as nomC,c.numSS as numSSC,o.nom as nomO,r.annulation,r.date_heure,r.pkArtif from rendezVous r,utilisateur u,contact c,organisation o WHERE r.utilisateur IN (SELECT numSS FROM utilisateur WHERE nom LIKE ? AND prenom LIKE ?) AND r.utilisateur=u.numSS AND c.numSS=r.contact AND o.nom=c.organisation ORDER BY date_heure DESC";
			$val = array('%'.$_POST['nomUser'].'%','%'.$_POST['prenomUser'].'%');
		}
		else
		{
			$sql = "select u.prenom as prenomU,u.nom as nomU,u.numSS as numSSU,c.prenom as prenomC,c.nom as nomC,c.numSS as numSSC,o.nom as nomO,r.annulation,r.date_heure,r.pkArtif from rendezVous r,utilisateur u,contact c,organisation o WHERE r.utilisateur IN (SELECT numSS FROM utilisateur WHERE nom LIKE ?) AND r.utilisateur=u.numSS AND c.numSS=r.contact AND o.nom=c.organisation ORDER BY date_heure DESC";
			$val = array('%'.$_POST['nomUser'].'%');		
		}		
	}
}

if(!empty($_POST['contactSearch']))
{
	if(empty($_POST['nomContact'])) {
		if(!empty($_POST['prenomContact']))
		{
			$sql = "select u.prenom as prenomU,u.nom as nomU,u.numSS as numSSU,c.prenom as prenomC,c.nom as nomC,c.numSS as numSSC,o.nom as nomO,r.annulation,r.date_heure,r.pkArtif from rendezVous r,utilisateur u,contact c,organisation o WHERE r.utilisateur=u.numSS AND c.numSS=r.contact AND o.nom=c.organisation ORDER BY date_heure DESC";
			$val = array('%'.$_POST['prenomContact'].'%');
		}
	}
	else
	{
		if(!empty($_POST['prenomContact']))
		{
			$sql = "select u.prenom as prenomU,u.nom as nomU,u.numSS as numSSU,c.prenom as prenomC,c.nom as nomC,c.numSS as numSSC,o.nom as nomO,r.annulation,r.date_heure,r.pkArtif from rendezVous r,utilisateur u,contact c,organisation o WHERE r.utilisateur=u.numSS AND c.numSS=r.contact AND o.nom=c.organisation ORDER BY date_heure DESC";
			$val = array('%'.$_POST['nomContact'].'%','%'.$_POST['prenomContact'].'%');
		}
		else
		{
			$sql = "select u.prenom as prenomU,u.nom as nomU,u.numSS as numSSU,c.prenom as prenomC,c.nom as nomC,c.numSS as numSSC,o.nom as nomO,r.annulation,r.date_heure,r.pkArtif from rendezVous r,utilisateur u,contact c,organisation o WHERE r.utilisateur=u.numSS AND c.numSS=r.contact AND o.nom=c.organisation ORDER BY date_heure DESC";
			$val = array('%'.$_POST['nomContact'].'%');		
		}		
	}	
}

if(!empty($_POST['dateSearch']))
{
	if(empty($_POST['dateInf']))
	{
		if(!empty($_POST['dateSup']))
		{
			$sql="select u.prenom as prenomU,u.nom as nomU,u.numSS as numSSU,c.prenom as prenomC,c.nom as nomC,c.numSS as numSSC,o.nom as nomO,r.annulation,r.date_heure,r.pkArtif from rendezVous r,utilisateur u,contact c,organisation o where r.utilisateur=u.numSS AND c.numSS=r.contact AND o.nom=c.organisation AND date_heure<? ORDER BY date_heure DESC";
			$val=array($_POST['dateSup']);
		}
	}
	else
	{
		if(empty($_POST['dateSup']))
		{
			$sql="select u.prenom as prenomU,u.nom as nomU,u.numSS as numSSU,c.prenom as prenomC,c.nom as nomC,c.numSS as numSSC,o.nom as nomO,r.annulation,r.date_heure,r.pkArtif from rendezVous r,utilisateur u,contact c,organisation o where r.utilisateur=u.numSS AND c.numSS=r.contact AND o.nom=c.organisation AND date_heure>? ORDER BY date_heure DESC";
			$val=array($_POST['dateInf']);
		}
		else
		{
			$sql="select u.prenom as prenomU,u.nom as nomU,u.numSS as numSSU,c.prenom as prenomC,c.nom as nomC,c.numSS as numSSC,o.nom as nomO,r.annulation,r.date_heure,r.pkArtif from rendezVous r,utilisateur u,contact c,organisation o where r.utilisateur=u.numSS AND c.numSS=r.contact AND o.nom=c.organisation AND date_heure<? AND date_heure>? ORDER BY date_heure DESC";
			$val=array($_POST['dateSup'],$_POST['dateInf']);
		}
	}	
}

$display.="<ul>";

if(!empty($sql))
{
	$req=$db->prepare($sql);
	$req->execute($val);
	
	if($req->rowCount() > 0)
	{
		while($result = $req->fetch(PDO::FETCH_ASSOC))
		{
			$display.='<li><a href="index.php?page=rdv/list&id='.$result['pkArtif'].'">'.strftime('%d/%m/%Y', strtotime($result['date_heure'])).' ('.strftime('%H:%M', strtotime($result['date_heure'])).')</a> - ';
			$display.='<a href="index.php?page=user/list&id='.$result['numSSU'].'">'.$result['prenomU'].' '.$result['nomU'].'</a> avec ';
			$display.='<a href="index.php?page=contact/list&id='.$result['numSSC'].'">'.$result['prenomC'].' '.$result['nomC'].' - ';
			$display.="".check_cancel($result['annulation'])."</li>";
		}
	}
	else
	{
		$display.="<li>Aucun résultat ne correspond à votre recherche</li>";
	}
}
else
{
	$display.="<li>Aucun résultat ne correspond à votre recherche</li>";
}

$display.="</ul>";
		
?>

<div id="wrapper">
	<div class="box">
		<h2>Recherche</h2>		
		<form method="post" action="index.php?page=search">			
		<p>
			<b>Rechercher des rendez-vous par utilisateur</b><br />
			Nom : <input type="text" name="nomUser" /><br />
			Prénom : <input type="text" name="prenomUser" /><br />
			<input type="submit" name="userSearch" value="Chercher" />
		</p>		
		<p>
			<b>Rechercher des rendez-vous par contact</b><br />
			Nom : <input type="text" name="nomContact" /><br />
			Prénom : <input type="text" name="prenomContact" /><br />
			<input type="submit" name="contactSearch" value="Chercher" />
		</p>		
		<p>
			<b>Rechercher des rendez-vous dans un intervalle de date</b><br />
			Date inférieure (yyyy-mm-jj hh:mm:ss) : <input type="text" name="dateInf" /><br />
			Date supérieure (yyyy-mm-jj hh:mm:ss) : <input type="text" name="dateSup" /><br />
			<input type="submit" name="dateSearch" value="Chercher" />
		</p>
		</form>
		
		
		<?php echo $display; ?>
		
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<?php echo $displayAction; ?>
	</ul>
</div>