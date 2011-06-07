<?php

if(!empty($_GET['id']))
{
	$req=$db->prepare("select numSS from contact where numSS=?");
	$req->execute(array($_GET['id']));
	
	if($req->rowCount() == 0)
	{
		header("Location: index.php?page=general/message&type=error&msg=Contact introuvable.&retour=contact/list");
	}
	else
	{
		$req=$db->prepare("DELETE FROM rendezVous WHERE contact=?");
		$req->execute(array($_GET['id']));
		$req=$db->prepare("DELETE FROM contact WHERE numSS=?");
		$req->execute(array($_GET['id']));
		header("Location: index.php?page=general/message&type=confirm&msg=Le contact a bien été supprimé.&retour=contact/list");
	}
	
}
else
{
	header("Location: index.php?page=general/message&type=error&msg=Lien cassé. Veuillez en référer au responsable du site web.&retour=contact/list");
}

?>