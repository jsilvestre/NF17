<?php

$display = "";

if(!empty($_POST['submit']))
{
	if(!empty($_POST['login']) && !empty($_POST['pword']))
	{
		$req=$db->prepare("select numSS,is_special from utilisateur where login=? AND mdp=?");
		$req->execute(array($_POST['login'],$_POST['pword']));
		
		if($req->rowCount() == 1)
		{
			$result = $req->fetch(PDO::FETCH_ASSOC);
			$_SESSION['id'] = $result['numSS'];
			$_SESSION['isAdmin'] = $result['is_special'];
			
			header('Location: index.php');
		}
		else
		{
			$display.="<p>Erreur : Nom d'utilisateur ou mot de passe incorrect.</p>";
		}
	}
	else
	{
		$display.= "<p>Erreur : Veuillez remplir tous les champs</p>";
	}
}

if(!empty($_SESSION['id']))
{
	$display.= "<p>Hi</p>";
}
else
{
	$display.='<form method="post" action="index.php?page=">
					<p>Login : <input type="text" name="login" /><br />
					Mot de passe : <input type="password" name="pword" /><br />
					<input type="submit" name="submit" value="Se connecter" /></p>
				</form>';
}


?>
<div id="wrapper">
	<div class="box">
		<h2>Accueil</h2>
		<?php echo $display; ?>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<p>Aucune action possible...</p>
</div>