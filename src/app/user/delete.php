<?php

if(!empty($_GET['id']))
{
	$req=$db->prepare("select numSS from utilisateur where numSS=?");
	$req->execute(array($_GET['id']));
	
	if($req->rowCount() == 0)
	{
		header("Location: index.php?page=general/message&type=error&msg=Utilisateur introuvable.&retour=user/list");
	}
	else
	{
		$req=$db->prepare("DELETE FROM utilisateur WHERE numSS=?");
		$req->execute(array($_GET['id']));
		header("Location: index.php?page=general/message&type=confirm&msg=L'utilisateur a bien été supprimé.&retour=user/list");
	}
	
}
else
{
	header("Location: index.php?page=general/message&type=error&msg=Lien cassé. Veuillez en référer au responsable du site web.&retour=user/list");
}

?>