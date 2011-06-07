<?php

if(!empty($_GET['id']))
{
	$req=$db->prepare("select pkArtif from rendezVous where pkArtif=?");
	$req->execute(array($_GET['id']));
	
	if($req->rowCount() == 0)
	{
		header("Location: index.php?page=general/message&type=error&msg=Rendez-vous introuvable.&retour=rdv/list");
	}
	else
	{
		$req=$db->prepare("UPDATE rendezVous SET annulation=1 WHERE pkArtif=?");
		$req->execute(array($_GET['id']));
		header("Location: index.php?page=general/message&type=confirm&msg=Le rendez-vous a bien été annulé.&retour=rdv/list");
	}
	
}
else
{
	header("Location: index.php?page=general/message&type=error&msg=Lien cassé. Veuillez en référer au responsable du site web.&retour=rdv/list");
}