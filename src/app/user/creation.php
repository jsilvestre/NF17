<div id="wrapper">
	<div class="box">
		<h2>Fenêtre principale</h2>
		<form method="post" action="./app/user/add.php">
				<p>  Nom d'utilisateur : <input type="text" name="login" /><BR>
				Nom: <input type="text" name="nom" /> <BR>
				Prénom : <input type="text" name="prenom" /> <BR>
				Date de naissance (JJ MM AAAA): <input type="text" name="jour" /> - <input type="text" name="mois" /> - <input type="text" name="an" /> <BR>
				Numéro de sécurité sociale : <input type="text" name="numSS" /> <BR>
				Mot de passe : <input type="text" name="mdp" /> <BR>
				<input type="submit" value="Valider" />
</p>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<li><a href="index.php?page=./user/creation">Creation utilisateur</a></li>
	</ul>
</div>



