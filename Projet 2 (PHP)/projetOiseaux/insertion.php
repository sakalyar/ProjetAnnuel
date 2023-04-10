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
    <li><a href="#">Accueil</a></li>
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
	// Lecture du fichier CSV
$file = fopen("contact_data.csv","r+");

// Tableau pour stocker les données
$data = array();

// Parcourir chaque ligne du fichier CSV
while (($row = fgetcsv($file)) !== FALSE) {
    // Ajouter chaque ligne à notre tableau
    $data[] = $row;
}

// Afficher les données en HTML
echo "<form method='post'>";
if ($data) {
    echo 'Données en attente d\'enregistrement.';
    echo "<table>";
    foreach ($data as $i => $row) {
    echo "<tr>";
    foreach ($row as $j => $cell) {
        echo "<td><input type='text' name='data[$i][$j]' value='$cell' /></td>";
    }
    echo "</tr>";
}

    echo "</table>";
	echo "<input type='submit' name='submit' value='Enregistrer'>";
} else {
    echo 'Aucune donnée à afficher.';
}

echo "</form>";

// Enregistre les modifications dans le fichier CSV
if (isset($_POST['submit'])) {
    foreach ($data as $i => $row) {
        foreach ($row as $j => $cell) {
            if (isset($_POST['data'][$i][$j])) {
                $data[$i][$j] = $_POST['data'][$i][$j];
            }
        }
    }

    fseek($file, 0); // Se positionner au début du fichier
    ftruncate($file, 0); // Vider le fichier
    foreach ($data as $row) {
        fputcsv($file, $row);
		header("Refresh:0");
    }
}
fclose($file);
?>
<br>
<br>
<!-- Afficher un formulaire avec un bouton "submit" -->
<form method="post" action="verifier.php">
    <input type="submit" name="submit" value="Envoyée les données">
</form>


</body>
</html>
