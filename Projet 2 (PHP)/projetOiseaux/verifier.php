<?php
	
// Vérifier si le formulaire a été soumis
if (isset($_POST['submit'])) {
	
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
    
    // Ouvrir le fichier CSV en lecture seule
    $file = fopen('contact_data.csv', 'r');
    
 // Lire les données du fichier CSV et les insérer dans la base de données
   while (($row = fgetcsv($file)) !== false) {
    $sql = "INSERT INTO oiseaux (nb_individue, nb_couple, indice_nidif,remarque,checkbox,id_typ)
            VALUES ('" . mysqli_real_escape_string($mysqli, $row[0]) . "', '" . mysqli_real_escape_string($mysqli, $row[1]) . "', '" . mysqli_real_escape_string($mysqli, $row[2]) . "', '" . mysqli_real_escape_string($mysqli, $row[3]) . "', '" . mysqli_real_escape_string($mysqli, $row[4]) . "', '" . mysqli_real_escape_string($mysqli, $row[5]) . "')";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die('Erreur de préparation de la requête SQL : ' . mysqli_error($mysqli));
    }
    $stmt->execute();
    if ($stmt->errno) {
        die('Erreur lors de l\'exécution de la requête SQL : ' . $stmt->error);
    }
    echo '<script language="Javascript">
            alert ("insertion reussi !" )
            </script>';
}
	
   // Ferme le fichier CSV
fclose($file);
	$filename = "contact_data.csv";
    // Vide le contenu du fichier CSV
$file = fopen($filename, "w");
if ($file === false) {
    echo "Impossible d'ouvrir le fichier $filename en écriture";
} else {
    ftruncate($file, 0);
    echo "Le fichier $filename a été vidé avec succès";
    fclose($file);
}

    header('Location: insertion.php');
	// Rediriger l'utilisateur vers une autre page
					 
    exit();
	

	$mysqli->close();
}

?>
    