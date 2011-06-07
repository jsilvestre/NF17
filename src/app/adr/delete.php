<?php

if(!empty($_GET['id']))
{
	$req=$db->prepare("select * from adresse where pkArtif=?");
	$req->execute(array($_GET['id']));
	
	if($req->rowCount() == 0)
	{
		header("Location: index.php?page=general/message&type=error&msg=Adresse introuvable.&retour=firm/list");
	}
	else
	{
		$req=$db->prepare("DELETE FROM Adresse WHERE pkArtif=?");
		$req->execute(array($_GET['id']));
		header("Location: index.php?page=general/message&type=confirm&msg=L'adresse a bien été supprimée.&retour=firm/list");
	}
	
}
else
{
	header("Location: index.php?page=general/message&type=error&msg=Lien cassé. Veuillez en référer au responsable du site web.&retour=firm/list");
}