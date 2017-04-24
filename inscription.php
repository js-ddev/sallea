<?php 

?>

<h1>Inscription</h1>
<?= $msg ?>
<form action="" method="post">

	<label>Pseudo</label>
	<input type="text" name="pseudo">

	<label>Mot de passe</label>
	<input type="text" name="mdp">

	<label>Nom</label>
	<input type="text" name="nom">

	<label>Prénom</label>
	<input type="text" name="prenom">

	<label>Email</label>
	<input type="text" name="email">

	<label>Civilité</label>
	<select name="civilite">
		<option value="m">Homme</option>
		<option value="f">Femme</option>

	</select>

	<label>Ville: </label>
	<input type="text" name="ville">

	<label>Code Postal </label>
	<input type="text" name="code_postal">

	<label>Adresse </label>
	<input type="text" name="adresse">

	<input type="submit" value="Inscription">


</form>