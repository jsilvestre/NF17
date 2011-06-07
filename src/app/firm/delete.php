<?php

if(!empty($_GET['id']))
{
	$req=$db->prepare("select nom from organisation where nom=?");
	$req->execute(array($_GET['id']));
	
	if($req->rowCount() == 0)
	{
		header("Location: index.php?page=general/message&type=error&msg=Organisation introuvable.&retour=firm/list");
	}
	else
	{
		$req=$db->prepare("DELETE FROM organisation WHERE nom=?");
		$req->execute(array($_GET['id']));
		header("Location: index.php?page=general/message&type=confirm&msg=L'organisation a bien été supprimé.&retour=firm/list");
	}
	
}
else
{
	header("Location: index.php?page=general/message&type=error&msg=Lien cassé. Veuillez en référer au responsable du site web.&retour=firm/list");
}

?>