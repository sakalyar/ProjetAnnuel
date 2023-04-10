<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Ma page</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
  <ul>
    <li><a href="insertion.php">Accueil</a></li>
	<li><a href="ajout_donnees.php">Ajouter</a></li>
    <li><a href="list.php">List</a></li>
	 <li><button onclick="deconnexion()">Déconnexion</button></li>
	 <script type="text/javascript">
	 
		function deconnexion() {
			localStorage.removeItem("user"); //supprime la clé "user" du local storage
			alert("Vous avez été déconnecté."); //affiche une alerte pour informer l'utilisateur
			location = "index.php"
		}
	</script>
  </ul>
</nav>
	<h1>Bienvenue sur ma page !</h1>
	
<?php
// Ouvrir une connexion à la base de données MySQL
$BDD = array();
$BDD['host'] = "localhost";
$BDD['user'] = "user";
$BDD['pass'] = "User123456789.";
$BDD['db'] = "bddoiseaux";
    $mysqli = mysqli_connect($BDD['host'], $BDD['user'], $BDD['pass'], $BDD['db']);
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }
// Exécuter une requête SQL pour récupérer les données de la table
$sql = 'SELECT O.nb_individue, O.nb_couple, O.indice_nidif, O.remarque,O.checkbox, T.type FROM oiseaux O, type_oiseaux T where O.id_typ = T.id_type';
$result = $mysqli->query($sql);

// Afficher les données dans une table HTML
if ($result->num_rows > 0) {
    echo '<table>';
    echo '<thead><tr><th>nombre individue</th><th>nombre couple</th><th>indice nidification</th><th>remarque</th><th>checkbox</th><th>type de oiseaux</th></tr></thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['nb_individue'] . '</td>';
        echo '<td>' . $row['nb_couple'] . '</td>';
        echo '<td>' . $row['indice_nidif'] . '</td>';
		echo '<td>' . $row['remarque'] . '</td>';
		echo '<td>' . $row['checkbox'] . '</td>';
		echo '<td>' . $row['type'] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo 'Aucune donnée à afficher.';
}

// Fermer la connexion à la base de données
$mysqli->close();
?>

</body>
</html>
