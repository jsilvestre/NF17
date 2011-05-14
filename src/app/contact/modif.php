<div id="wrapper">
	<div class="box">
		<h2>Accueil</h2>
		
		<?php
			// CREATION DU FORMULAIRE DE CHOIX
			echo " <p> <form method=\"post\" action=\"./app/contact/modif1.php\">";
			echo "Numero d'identification du contact à modifier : ";
			echo "<select name=\"id\">";
			
			// CONNEXION A LA BASE DE DONNEES
			mysql_connect('localhost','root','');	
			mysql_select_db('NF17');
			
			// CREATION DE LA REQUETE
			$query=('SELECT identifiant FROM contact');
			
			// INSERTION DES LIGNES DANS LE FORMULAIRE
			$result=mysql_query($query);
				if ($result==FALSE)
					echo "erreur mysql query";
				while($row = mysql_fetch_row($result)) {			
					echo "<option value=$row[0]> $row[0]</option>";
				}
			echo "</select>	";
		?>
		<BR>
		<input type="submit" value="Valider" />
		</p>
	</div>
</div>

<div id="action">
	<h2>Actions possibles</h2>
	<ul>
		<li><a href="index.php?page=./contact/creation">Creation d'un contact</a></li>
		<li><a href="index.php?page=./contact/modif">modification d'un contact</a></li>
		<li><a href="index.php?page=./contact/supprim">Suppression d'un contact</a></li>
	</ul>
</div>