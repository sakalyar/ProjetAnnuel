 <?php
//connexion à la base de données:
$BDD = array();
$BDD['host'] = "localhost";
$BDD['user'] = "user";
$BDD['pass'] = "User123456789.";
$BDD['db'] = "bddoiseaux";
$mysqli = mysqli_connect($BDD['host'], $BDD['user'], $BDD['pass'], $BDD['db']);
if(!$mysqli) {
    echo "Connexion non établie.";
    exit;
}

$AfficherFormulaire=1;
//traitement du formulaire:
if(isset($_POST['id_t'], $_POST['nb_individue'], $_POST['nb_couple'], $_POST['indice_nidif'], $_POST['remarque'], $_POST['check'])) {
    // récupérer les valeurs des cases à cocher
    $casesCochees = isset($_POST['check']) ? $_POST['check'] : array();
    $checkbox = implode(',', $casesCochees);

    // préparer la requête SQL avec des paramètres préparés pour éviter les injections SQL
    $requete = "INSERT INTO oiseaux (nb_individue, nb_couple, indice_nidif, remarque, checkbox, id_typ) VALUES (?, ?, ?, ?, ?, ?)"; 
    $statement = mysqli_prepare($mysqli, $requete);

    // lier les paramètres à la requête
    mysqli_stmt_bind_param($statement, "iiisss", $_POST['nb_individue'], $_POST['nb_couple'], $_POST['indice_nidif'], $_POST['remarque'], $checkbox, $_POST['id_t']);

    // exécuter la requête
    mysqli_stmt_execute($statement);

    // afficher un message de succès
    echo '<script language="Javascript">
            alert("session enregistrée avec succès !");
          </script>';
    echo '<script>location = "ajout_donnees.php"</script>';
}



else
{
			echo '<script language="Javascript">
				alert ("erreur !" )
				
					 </script>';
					 echo '<script>location = "ajout_donnees.php"</script>';
           // utilisateur ou mot de passe incorrect
}
    

if($AfficherFormulaire==1){
   
}

?>